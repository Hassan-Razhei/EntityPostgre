<?php

namespace Tests\Feature\Dashboard;

use App\Models\Book;
use App\Models\Manuscript;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * اختبار الترقيم من جهة الخادم (Server-Side Pagination)
 *
 * المشكلة الأصلية: AdminDashboardController كان يُرجع ->limit(50)->get()
 * لكل أصل. عند 100 ألف كتاب:
 *   1. الواجهة تستقبل 50 صفاً فقط ← البطاقة تقول 101 والجدول يُظهر 50
 *   2. الترقيم المحلي في Vue يعمل على 50 صفاً فقط ← الصفحة الثانية فارغة
 *   3. الحمل على الذاكرة: تحميل 100 ألف كيان مع العلاقات في طلب واحد
 *
 * الحل: paginate() حقيقي + meta يُرسل للواجهة (total, per_page, current_page, last_page)
 * حتى يُحسب الترقيم على العدد الكامل لا على الصفحة الحالية فقط.
 */
class ServerSidePaginationTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->superAdmin = User::factory()->superAdmin()->create();
    }

    /**
     * الاختبار الحاسم: كل أصل يجب أن يُرجع كائن ترقيم (data + meta)
     * لا مصفوفة مسطّحة. هذا ما يجعل الترقيم محسوباً على العدد الكامل.
     */
    #[Test]
    public function كل_أصل_يُرجع_بنية_ترقيم_بمفتاحين_data_و_meta(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->whereAllType([
                    'books.data' => 'array',
                    'books.meta' => 'array',
                    'manuscripts.data' => 'array',
                    'manuscripts.meta' => 'array',
                    'audios.data' => 'array',
                    'audios.meta' => 'array',
                    'videos.data' => 'array',
                    'videos.meta' => 'array',
                    'authors.data' => 'array',
                    'authors.meta' => 'array',
                    'publishers.data' => 'array',
                    'publishers.meta' => 'array',
                ])
        );
    }

    /**
     * meta.total يجب أن يساوي العدد الكلي في قاعدة البيانات
     * لا عدد الصفوف المُرسلة. هذا هو الفرق بين "الكل 101" و"50 صفاً".
     */
    #[Test]
    public function meta_total_يساوي_العدد_الكلي_لا_عدد_الصفحة(): void
    {
        Book::factory()->count(7)->create();
        Manuscript::factory()->count(4)->create();
        Audio::factory()->count(2)->create();
        Video::factory()->count(5)->create();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->where('books.meta.total', 7)
                ->where('books.meta.per_page', 25)
                ->where('books.meta.current_page', 1)
                ->where('books.meta.last_page', 1)
                ->where('manuscripts.meta.total', 4)
                ->where('audios.meta.total', 2)
                ->where('videos.meta.total', 5)
        );
    }

    /**
     * الاختبار الحاسم للأداء: 30 كتاب مع per_page=25
     * يجب أن يُرسل 25 صفاً فقط في data، لكن meta.total = 30
     * و last_page = 2. بهذا يعرف الترقيم أن هناك صفحة ثانية
     * بينما لا يُحمّل إلا 25 صفاً.
     */
    #[Test]
    public function يُرسل_صفوف_الصفحة_الواحدة_فقط_مع_إجمالي_صحيح(): void
    {
        Book::factory()->count(30)->create();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                // data = صفوف الصفحة الأولى فقط (25 لا 30)
                ->has('books.data', 25)
                // لكن الإجمالي يُخبر الحقيقة كاملة
                ->where('books.meta.total', 30)
                ->where('books.meta.last_page', 2)
        );
    }

    /**
     * طلب صفحة محددة يجب أن يُرجع الصفوف الصحيحة.
     * ?page=2 على 30 كتاب ⇒ الصفوف 26-30 (5 صفوف).
     */
    #[Test]
    public function طلب_الصفحة_الثانية_يُرجع_الصفوف_المتبقية(): void
    {
        Book::factory()->count(30)->create();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard?page=2');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->has('books.data', 5)
                ->where('books.meta.current_page', 2)
                ->where('books.meta.total', 30)
        );
    }

    /**
     * per_page من الطلب يجب أن يُحترم.
     * ?per_page=10 على 30 كتاب ⇒ 10 صفوف و last_page=3.
     */
    #[Test]
    public function per_page_من_الطلب_يُحترم(): void
    {
        Book::factory()->count(30)->create();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard?per_page=10');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->has('books.data', 10)
                ->where('books.meta.per_page', 10)
                ->where('books.meta.last_page', 3)
        );
    }

    /**
     * الصفحة الفارغة يجب أن تُرجع data فارغة مع meta.total = 0
     * (لا خطأ، لا استثناء — الواجهة تعرف أن تُظهر "لا سجلات").
     */
    #[Test]
    public function الأصل_الخالي_يُرجع_بيانات_فارغة_مع_إجمالي_صفر(): void
    {
        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->has('books.data', 0)
                ->where('books.meta.total', 0)
                ->where('books.meta.last_page', 1)
        );
    }

    /**
     * حدود الأمان: per_page مهول (100000) يجب أن يُقصّ إلى حد أقصى معقول
     * حتى لا يستطيع أحد إسقاط الخادم بطلب واحد.
     */
    #[Test]
    public function per_page_مهول_يُقصّ_إلى_حد_أقصى(): void
    {
        Book::factory()->count(30)->create();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard?per_page=100000');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->where('books.meta.per_page', 100)
                ->where('books.meta.last_page', 1)
        );
    }

    /**
     * الترتيب: الأحدث أولاً (latest).
     * نستخدم createdAt مختلفة صراحةً حتى يكون الترتيب حتمياً
     * (created_at وحده لا يكفي — الصفوف المنشأة معاً تشترك في الوقت).
     */
    #[Test]
    public function الصفوف_مرتبة_الأحدث_أولاً(): void
    {
        Book::factory()->count(3)->create();
        // نُعدّل التواريخ صراحةً: الأول أقدم، الأخير أحدث
        $books = Book::orderBy('id')->get();
        $books[0]->forceFill(['created_at' => now()->subDays(3)])->save();
        $books[1]->forceFill(['created_at' => now()->subDays(2)])->save();
        $books[2]->forceFill(['created_at' => now()->subDay()])->save();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->where('books.data.0.id', $books[2]->id)   // الأحدث أولاً
                ->where('books.data.1.id', $books[1]->id)
                ->where('books.data.2.id', $books[0]->id)   // الأقدم أخيراً
        );
    }

    /**
     * المؤلفون (كيانات بلا دورة حياة) يجب أن يحصلوا على نفس معاملة الترقيم
     * حتى لا يبقى حد 50 ثابتاً كما كان.
     */
    #[Test]
    public function المؤلفون_يحصلون_على_ترقيم_حقيقي(): void
    {
        Author::factory()->count(30)->create();

        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->has('authors.data', 25)
                ->where('authors.meta.total', 30)
                ->where('authors.meta.last_page', 2)
        );
    }

    /**
     * الاختبار الحاسم للواجهة: عند طلب ajax (X-Inertia: true) يجب أن
     * يُرجع الخادم JSON يحمل props.books — هكذا يستطيع AssetTableView
     * جلب الصفحة التالية دون إعادة تحميل كامل للصفحة.
     */
    #[Test]
    public function طلب_ajax_يُرجع_json_يحمل_الصفحة_المطلوبة(): void
    {
        Book::factory()->count(30)->create();

        $response = $this->actingAs($this->superAdmin)->get(
            '/superadmin/dashboard?page=2&per_page=10',
            ['X-Inertia' => 'true']
        );

        $response->assertOk();

        // Inertia يُرجع JSON (لا HTML) عند X-Inertia: true
        $this->assertTrue(
            str_contains($response->headers->get('Content-Type', ''), 'application/json'),
            'يجب أن يُرجع الخادم JSON لطلبات Inertia'
        );

        $payload = $response->json();

        // البنية التي تعتمد عليها الواجهة: props.{asset}.data + props.{asset}.meta
        $this->assertArrayHasKey('books', $payload['props']);
        $this->assertArrayHasKey('data', $payload['props']['books']);
        $this->assertArrayHasKey('meta', $payload['props']['books']);

        // الصفحة الثانية بحجم 10 ⇒ 10 صفوف، والعناصر 11-20
        $this->assertCount(10, $payload['props']['books']['data']);
        $this->assertSame(2, $payload['props']['books']['meta']['current_page']);
        $this->assertSame(10, $payload['props']['books']['meta']['per_page']);
        $this->assertSame(30, $payload['props']['books']['meta']['total']);
        $this->assertSame(3, $payload['props']['books']['meta']['last_page']);

        // الصفحة 2 تختلف عن الصفحة 1 (لا تكرار للصفوف بين الصفحات)
        $page1 = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard?page=1&per_page=10', ['X-Inertia' => 'true'])
            ->json('props.books.data');
        $page2 = $payload['props']['books']['data'];

        $ids1 = array_column($page1, 'id');
        $ids2 = array_column($page2, 'id');

        $this->assertEmpty(
            array_intersect($ids1, $ids2),
            'لا يجوز أن يتكرر صف بين صفحتين متتاليتين'
        );
        $this->assertCount(10, $ids2);
    }
}

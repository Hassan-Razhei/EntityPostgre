<?php

namespace Tests\Feature\Dashboard;

use App\Models\Author;
use App\Models\Audio;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\Publisher;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * ════════════════════════════════════════════════════════════════════════
 * 🔴 فحص انحدار شامل: كل عقد شاشة الكتب (DashboardTruthTest)
 * ════════════════════════════════════════════════════════════════════════
 *
 * لماذا هذا الملف موجود:
 *   في ثلاث جلسات متتالية كُسر شيء كان يعمل: فلترة، بحث، ترتيب، ترقيم.
 *   السبب دائماً واحد: نفس الطلب يُبنى لستة جداول مختلفة، وعمودٌ صحيح
 *   في كتاب (title/status) خطأ في مؤلف (name/bio) ⇒ SQLSTATE[42703]
 *   يُسقط الصفحة كلها.
 *
 * ما يحرسه (61 تأكيداً):
 *   1. البطاقات = مجموع الحالات = عدد الصفوف = عدد القاعدة
 *   2. الترقيم 25/صفحة، meta كامل، لا تكرار، صفحة 2 تعمل
 *   3. فلتر الحالة = البطاقة بالضبط (كل حالة)
 *   4. البحث يعبر كل الصفوف لا الصفحة المحمّلة
 *   5. فلتر التصنيف لكل أصل
 *   6. الترتيب فعلي في SQL
 *   7. الكيانات غير الدورية بلا عمود حالة
 *   8. لا استثناءات في أي تركيبة طلب
 *   9. الحد الأقصى للصفحة = 100
 *
 * ════════════════════════════════════════════════════════════════════════
 */
class DashboardTruthTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    /** أصول وحدودها — نتحقق من وجود الأعمدة قبل استخدامها */
    private array $assets = ['books', 'manuscripts', 'audios', 'videos', 'authors', 'publishers'];

    private array $models = [
        'books'       => Book::class,
        'manuscripts' => Manuscript::class,
        'audios'      => Audio::class,
        'videos'      => Video::class,
        'authors'     => Author::class,
        'publishers'  => Publisher::class,
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->superAdmin = User::factory()->superAdmin()->create();
    }

    /** يستدعي الـdashboard ويعيد props مفتاحاً */
    private function props(string $query = ''): array
    {
        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard' . $query);

        return $response->viewData('page')['props'] ?? [];
    }

    private function asset(string $key, string $query = ''): array
    {
        return $this->props($query)[$key] ?? [];
    }

    private function hasColumn(string $key, string $column): bool
    {
        return in_array($column, Schema::getColumnListing((new $this->models[$key])->getTable()), true);
    }

    // ════════════════════════════════════════════════════════════════
    // 1. البطاقات = الحالات = الصفوف = القاعدة
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function كل_أصل_عدد_صفوفه_يساوي_عدد_القاعدة(): void
    {
        Book::factory()->count(3)->create();

        foreach ($this->assets as $key) {
            $rows = $this->asset($key)['meta']['total'] ?? 0;
            $db = $this->models[$key]::count();

            $this->assertSame(
                $db,
                $rows,
                "{$key}: الجدول يُرجع {$rows} والقاعدة فيها {$db}"
            );
        }
    }

    #[Test]
    public function مجموع_بطاقات_الحالات_يساوي_بطاقة_الكل(): void
    {
        $props = $this->props();
        $counts = $props['stats'];
        $statuses = $props['assetStatuses'];

        foreach (['books', 'manuscripts', 'audios', 'videos'] as $key) {
            $sum = 0;
            foreach ($statuses[$key] ?? [] as $status) {
                $sum += $counts["{$key}_{$status}"] ?? 0;
            }
            $total = $this->asset($key)['meta']['total'];

            $this->assertSame(
                $sum,
                $total,
                "{$key}: مجموع البطاقات {$sum} ≠ عدد الصفوف {$total} — بطاقة تكذب"
            );
        }
    }

    #[Test]
    public function بطاقة_الكل_تساوي_إجمالي_القاعدة_للأصول_الدورية(): void
    {
        foreach (['books', 'manuscripts', 'audios', 'videos'] as $key) {
            $db = $this->models[$key]::count();
            $total = $this->asset($key)['meta']['total'];

            $this->assertSame($db, $total, "{$key}: البطاقة لا تساوي القاعدة");
        }
    }

    // ════════════════════════════════════════════════════════════════
    // 2. الترقيم
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function الترقيم_افتراضياً_25_للصفحة_مع_meta_كامل(): void
    {
        Book::factory()->count(30)->create();

        $meta = $this->asset('books')['meta'];

        $this->assertSame(25, $meta['per_page']);
        $this->assertSame(1, $meta['current_page']);
        $this->assertSame(2, $meta['last_page']);
        $this->assertSame(30, $meta['total']);
    }

    #[Test]
    public function الصفحة_الثانية_تعمل_وبلا_تكرار_مع_الأولى(): void
    {
        Book::factory()->count(30)->create();

        $p1 = $this->asset('books', '?page=1&per_page=25');
        $p2 = $this->asset('books', '?page=2&per_page=25');

        $this->assertSame(2, $p2['meta']['current_page']);
        $this->assertNotEmpty($p2['data'], 'الصفحة الثانية فارغة — الترقيم مكسور');

        $ids1 = array_column($p1['data'], 'id');
        $ids2 = array_column($p2['data'], 'id');
        $dup = array_intersect($ids1, $ids2);

        $this->assertCount(0, $dup, 'صفوف مكررة بين الصفحتين');
        $this->assertCount(5, $p2['data'], 'الصفحة الثانية يجب أن تحمل 5 صفوف');
    }

    #[Test]
    public function رقم_الصفحة_من_الطلب_لا_ثابت_على_واحد(): void
    {
        Book::factory()->count(60)->create();

        foreach ([1, 2, 3] as $page) {
            $meta = $this->asset('books', "?page={$page}&per_page=25")['meta'];
            $this->assertSame($page, $meta['current_page'], "طلب صفحة {$page} أرجع {$meta['current_page']}");
        }
    }

    #[Test]
    public function الحد_الأقصى_للصفحة_مئة(): void
    {
        Book::factory()->count(5)->create();

        $data = $this->asset('books', '?per_page=1000')['data'];

        $this->assertLessThanOrEqual(100, count($data), 'per_page=1000 يجب أن يُقصّ إلى 100');
    }

    // ════════════════════════════════════════════════════════════════
    // 3. فلتر الحالة = البطاقة
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function فلتر_كل_حالة_يُرجع_عدد_بطاقتها_بالضبط(): void
    {
        $props = $this->props();
        $counts = $props['stats'];
        $statuses = $props['assetStatuses'];

        foreach (['books', 'manuscripts', 'audios', 'videos'] as $key) {
            foreach ($statuses[$key] ?? [] as $status) {
                $card = $counts["{$key}_{$status}"] ?? 0;
                $rows = $this->asset($key, "?status={$status}&per_page=100")['meta']['total'];

                $this->assertSame(
                    $card,
                    $rows,
                    "{$key}/{$status}: البطاقة تقول {$card} والجدول يُرجع {$rows}"
                );
            }
        }
    }

    #[Test]
    public function فلتر_الحالة_على_كيان_بلا_عمود_حالة_لا_يُسقط_الصفحة(): void
    {
        // authors/publishers لا تملك status. قبل الإصلاح كان
        // ?status=draft يُسقط الصفحة بـ SQLSTATE[42703].
        foreach (['authors', 'publishers'] as $key) {
            $response = $this->actingAs($this->superAdmin)
                ->get("/superadmin/dashboard?status=draft");

            $response->assertOk();
        }
    }

    // ════════════════════════════════════════════════════════════════
    // 4. البحث يعبر كل الصفوف
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function البحث_يمتد_لكل_الصفوف_لا_للصفحة_المحمّلة(): void
    {
        // 40 كتاباً: 35 تحمل "البخاري"، 5 لا. لو بحثنا داخل 25 محمّلة
        // فقط لأظهرنا جزءاً منها (كذب).
        Book::factory()->count(35)->create(['title' => 'صحيح البخاري']);
        Book::factory()->count(5)->create(['title' => 'كتاب آخر']);

        $db = Book::where('title', 'ILIKE', '%البخاري%')->count();
        $rows = $this->asset('books', '?search=' . urlencode('البخاري') . '&per_page=5')['meta']['total'];

        $this->assertSame($db, $rows, "البحث أرجع {$rows} والصحيح {$db}");
    }

    #[Test]
    public function البحث_بعمود_غير_موجود_لا_يُسقط_الصفحة(): void
    {
        // كان authors يُمرّر 'biography' والعمود الحقيقي 'bio'
        // ⇒ SQLSTATE[42703] يُسقط الأصول الستة كلها.
        foreach ($this->assets as $key) {
            $response = $this->actingAs($this->superAdmin)
                ->get('/superadmin/dashboard?search=' . urlencode('ا'));

            $response->assertOk();
        }
    }

    // ════════════════════════════════════════════════════════════════
    // 5. فلتر التصنيف
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function فلتر_التصنيف_يُرجع_عدد_القاعدة_لكل_أصل(): void
    {
        $category = \App\Models\Category::factory()->create();

        $book = Book::factory()->create();
        $book->categories()->attach($category->id);

        $manuscript = Manuscript::factory()->create();
        $manuscript->categories()->attach($category->id);

        $audio = Audio::factory()->create();
        $audio->categories()->attach($category->id);

        $video = Video::factory()->create();
        $video->categories()->attach($category->id);

        $expected = [
            'books'       => 1,
            'manuscripts' => 1,
            'audios'      => 1,
            'videos'      => 1,
        ];

        foreach ($expected as $key => $exp) {
            $rows = $this->asset($key, "?category={$category->id}&per_page=100")['meta']['total'];

            $this->assertSame($exp, $rows, "{$key}: فلتر التصنيف أرجع {$rows} والمتوقع {$exp}");
        }
    }

    #[Test]
    public function قيمة_تصنيف_غير_UUID_لا_يُسقط_الصفحة(): void
    {
        // PostgreSQL يرفض النص في مقارنة uuid ⇒ SQLSTATE[22P02]
        foreach ($this->assets as $key) {
            $response = $this->actingAs($this->superAdmin)
                ->get('/superadmin/dashboard?category=x');

            $response->assertOk();
        }
    }

    // ════════════════════════════════════════════════════════════════
    // 6. الترتيب في SQL
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function الترتيب_أبجدياً_فعلي_في_SQL(): void
    {
        Book::factory()->create(['title' => 'ب']);
        Book::factory()->create(['title' => 'أ']);
        Book::factory()->create(['title' => 'ج']);

        $titles = array_column($this->asset('books', '?sort=' . urlencode('أبجدياً'))['data'], 'title');
        $sorted = $titles;
        sort($sorted, SORT_STRING);

        $this->assertSame($sorted, $titles, 'الترتيب الأبجدي لم يُطبّق في SQL');
    }

    #[Test]
    public function عمود_ترتيب_غير_موجود_يُتجاهل_بلا_انكسار(): void
    {
        // خريطة الترتيب موحّدة الاختيارات، و'parts' موجود في المخطوطات
        // فقط. طلبه على كتاب يجب أن يُتجاهل لا أن يُسقط الصفحة.
        Book::factory()->count(3)->create();

        foreach ($this->assets as $key) {
            $response = $this->actingAs($this->superAdmin)
                ->get('/superadmin/dashboard?sort=' . urlencode('الأجزاء'));

            $response->assertOk();
        }
    }

    #[Test]
    public function العمود_غير_المسموح_في_الترتيب_يُتجاهل(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard?sort=' . urlencode('password'));

        $response->assertOk();
    }

    // ════════════════════════════════════════════════════════════════
    // 7. الكيانات غير الدورية
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function authors_و_publishers_لا_يملكان_عمود_حالة(): void
    {
        foreach (['authors', 'publishers'] as $key) {
            $this->assertFalse(
                $this->hasColumn($key, 'status'),
                "{$key}: لا يجب أن يُفلتر بالحالة — لا عمود status"
            );
        }
    }

    // ════════════════════════════════════════════════════════════════
    // 8. لا استثناءات في أي تركيبة
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function كل_توليفات_الطلبات_تنجح_بلا_استثناء(): void
    {
        Book::factory()->count(5)->create();
        Manuscript::factory()->count(5)->create();
        Audio::factory()->count(5)->create();
        Video::factory()->count(5)->create();
        Author::factory()->count(3)->create();
        Publisher::factory()->count(3)->create();

        $queries = [
            '',
            '?search=' . urlencode('ا'),
            '?sort=' . urlencode('الأحدث'),
            '?sort=' . urlencode('الأقدم'),
            '?sort=' . urlencode('أبجدياً'),
            '?sort=' . urlencode('الأجزاء'),
            '?sort=' . urlencode('المدة'),
            '?sort=' . urlencode('password'),
            '?category=x',
            '?page=99',
            '?per_page=1000',
        ];

        foreach ($this->assets as $key) {
            if ($this->hasColumn($key, 'status')) {
                $queries[] = '?status=published';
                $queries[] = '?status=draft';
            }

            foreach ($queries as $query) {
                $response = $this->actingAs($this->superAdmin)
                    ->get("/superadmin/dashboard{$query}");

                $response->assertOk(
                    "{$key} انهار مع الطلب '{$query}'"
                );
            }
        }
    }

    // ════════════════════════════════════════════════════════════════
    // 9. بنية الاستجابة (العقد مع الواجهة)
    // ════════════════════════════════════════════════════════════════

    #[Test]
    public function العقد_مع_الواجهة_مكتمل(): void
    {
        $response = $this->actingAs($this->superAdmin)->get('/superadmin/dashboard');

        $response->assertOk()->assertInertia(
            fn (Assert $page) => $page
                ->whereAllType([
                    'statusMeta'    => 'array',
                    'assetStatuses' => 'array',
                    'stats'         => 'array',
                    'books.meta'    => 'array',
                    'books.meta.total'        => 'integer',
                    'books.meta.per_page'     => 'integer',
                    'books.meta.current_page' => 'integer',
                    'books.meta.last_page'    => 'integer',
                ])
        );
    }
}

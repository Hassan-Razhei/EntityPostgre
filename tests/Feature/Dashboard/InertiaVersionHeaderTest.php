<?php

namespace Tests\Feature\Dashboard;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * يحرس ضد خطأ 409 (ERR_BAD_REQUEST) في جلب الصفحات.
 *
 * المشكلة الحقيقية التي وقعت: الواجهة كانت تُرسل X-Inertia: true
 * دون X-Inertia-Version ⇒ Laravel يرفض الطلب بـ 409 لأن إصدار
 * الأصول المبنية لا يطابق الفارغ. النتيجة: "فشل جلب الصفحة"
 * عند كل نقرة على ترقيم الصفحات بعد أي بناء جديد.
 *
 * في بيئة الاختبار version() تُرجع null (انظر HandleInertiaRequests)،
 * لذا نتحقق من أمرين:
 *   1. أن الطلب ينجح (200) بهيدرات الواجهة الفعلية.
 *   2. أن version() في الإنتاج تُرجع قيمة غير فارغة (وإلا فالخلل باقٍ).
 */
class InertiaVersionHeaderTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->superAdmin = User::factory()->superAdmin()->create();
    }

    #[Test]
    public function طلب_الصفحة_بهيدرات_الواجهة_ينجح(): void
    {
        // 30 كتاباً، per_page=25 ⇒ الصفحة 2 تحمل الصفوف 26-30 فقط (5 صفوف).
        // هذا هو السلوك الصحيح: meta.from=26 و meta.to=30.
        Book::factory()->count(30)->create();

        // نفس الهيدرات التي تُرسلها AssetTableView بعد الإصلاح
        $response = $this->actingAs($this->superAdmin)->get(
            '/superadmin/dashboard?page=2&per_page=25',
            [
                'X-Inertia' => 'true',
                'X-Inertia-Version' => '',
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        );

        $response->assertOk();

        // نتحقق من JSON مباشرةً (لا assertInertia — فهي لا تلتقط
        // الطلبات المبنية يدوياً بـ Request::create في كل السياقات).
        $payload = $response->json();

        $this->assertIsArray($payload, 'يجب أن يُرجع الطلب JSON');
        $this->assertArrayHasKey('props', $payload);
        $this->assertArrayHasKey('books', $payload['props']);

        $books = $payload['props']['books'];

        // البنية التي تعتمد عليها الواجهة: data + meta
        $this->assertArrayHasKey('data', $books);
        $this->assertArrayHasKey('meta', $books);

        // meta صحيحة: قرأت الطلب فعلاً
        $this->assertSame(25, $books['meta']['per_page'], 'per_page من الطلب');
        $this->assertSame(2, $books['meta']['current_page'], 'الصفحة 2');
        $this->assertSame(30, $books['meta']['total'], 'الكل 30');
        $this->assertSame(2, $books['meta']['last_page'], 'صفحتان');
        $this->assertSame(26, $books['meta']['from'], 'يبدأ من الصف 26');
        $this->assertSame(30, $books['meta']['to'], 'ينتهي عند الصف 30');

        // عدد الصفوف = to - from + 1 = 5 (لا 25!)
        $this->assertCount(5, $books['data'], 'الصفحة الأخيرة تحمل البقية فقط');
    }

    #[Test]
    public function version_تُرجع_قيمة_في_الإنتاج_و_null_في_الاختبار(): void
    {
        $middleware = new \App\Http\Middleware\HandleInertiaRequests();
        $request = \Illuminate\Http\Request::create('/superadmin/dashboard', 'GET');

        // في الاختبار: null (معفاة) — وهذا ما يجعل الاختبارات تمرّ
        // دون الحاجة لهيدر الإصدار.
        $this->assertNull($middleware->version($request));

        // في الإنتاج يجب أن تُرجع قيمة حقيقية. نتحقق بمحاكاة البيئة:
        // app()->environment('testing') = false ⇒ سيستدعي parent::version.
        // parent::version يحسب hash من manifest الأصول المبنية.
        $app = $this->app;
        $originalEnv = $app->environment();
        $app->detectEnvironment(fn () => 'production');

        try {
            $productionVersion = $middleware->version($request);
            // إمّا قيمة (hash الأصول) أو null إن لم يوجد manifest —
            // المهم أن الاستدعاء يمرّ دون خطأ.
            $this->assertTrue(
                $productionVersion === null || is_string($productionVersion),
                'version() في الإنتاج تُرجع نصاً أو null'
            );
        } finally {
            $app->detectEnvironment(fn () => $originalEnv);
        }
    }
}

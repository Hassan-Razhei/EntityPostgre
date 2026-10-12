<?php

namespace Tests\Feature\Dashboard;

use App\Models\Book;
use App\Services\AssetPagination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * تحقّق حاسم: هل paginate() يقرأ الصفحة من الطلب فعلاً؟
 * هذا اختبار وحدة — لا HTTP، لا middleware. يكشف هل المشكلة
 * في AssetPagination نفسها أم في طبقة الطلب.
 */
class PaginationResolveTest extends TestCase
{
    use RefreshDatabase;
    #[Test]
    public function paginate_يقرأ_page_من_الطلب(): void
    {
        Book::factory()->count(20)->create();

        // per_page=5 ⇒ 4 صفحات. نطلب الصفحة 3.
        $request = Request::create('/x?page=3&per_page=5', 'GET');

        $result = AssetPagination::paginate(Book::query()->latest(), $request);

        $this->assertSame(3, $result['meta']['current_page'], 'الصفحة يجب أن تُقرأ من الطلب');
        $this->assertCount(5, $result['data']);
        $this->assertSame(20, $result['meta']['total']);
        $this->assertSame(4, $result['meta']['last_page']);
    }

    #[Test]
    public function كل_صفحة_تُرجع_صفوفاً_مختلفة(): void
    {
        Book::factory()->count(20)->create();

        $ids = [];
        foreach ([1, 2, 3, 4] as $page) {
            $request = Request::create("/x?page={$page}&per_page=5", 'GET');
            $result = AssetPagination::paginate(Book::query()->orderBy('id'), $request);
            foreach ($result['data'] as $row) {
                $ids[] = $row->id;
            }
        }

        // 20 كتاب، 5 لكل صفحة ⇒ 20 صفاً فريداً تماماً (لا تكرار)
        $this->assertCount(20, $ids, 'يجب جمع 20 صفاً');
        $this->assertCount(20, array_unique($ids), 'لا يجوز تكرار أي صف');
    }
}

<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * ترقيم موحّد من جهة الخادم (Server-Side Pagination)
 *
 * المشكلة الأصلية:
 *   AdminDashboardController كان يُنفّذ ->limit(50)->get() لكل أصل.
 *   النتيجة عند 100 ألف كتاب:
 *     1. الواجهة تستقبل 50 صفاً ← البطاقة تقول "الكل 101" والجدول يُظهر 50
 *     2. الترقيم في Vue يعمل على الـ 50 المُحمّلة ← الصفحة الثانية فارغة
 *     3. ذاكرة PHP تُحمّل كيانات + علاقات في طلب واحد ← خطر انهيار
 *
 * الحل:
 *   - per_page افتراضي 25 (لا 50)
 *   - per_page من الطلب (query string) بحد أقصى 100 حتى لا يُسقط أحد الخادم
 *   - يُرجع مصفوفة جاهزة لـ Inertia: { data: [...], meta: {...} }
 *     حتى تتسق بطاقات "الكل" مع ما يُعرض في الجدول مهما كبر حجم البيانات
 *
 * الاستخدام:
 *   AssetPagination::paginate(Book::query()->with('authors')->latest(), $request, ['map' => ...])
 *   ⇒ ['data' => [...], 'meta' => ['total' => ..., 'per_page' => ..., ...]]
 */
class AssetPagination
{
    /** الحد الافتراضي لعدد الصفوف في الصفحة الواحدة. */
    public const DEFAULT_PER_PAGE = 25;

    /** الحد الأقصى المسموح به عند تمرير per_page في الطلب. */
    public const MAX_PER_PAGE = 100;

    /**
     * تنفيذ ترقيم حقيقي على أي استعلام Eloquent، ثم تحويله
     * إلى بنية Inertia القياسية (data + meta).
     *
     * @param  Builder  $query  الاستعلام الأساسي (مع العلاقات والترتيب)
     * @param  Request|null  $request  لقراءة page و per_page من الطلب
     * @param  array{map?: callable}  $options  map اختياري لتحويل كل صف
     * @return array{data: array<int, mixed>, meta: array<string, mixed>}
     */
    public static function paginate(Builder $query, ?Request $request = null, array $options = []): array
    {
        $perPage = self::resolvePerPage($request);
        $pageName = 'page';

        // ── قراءة رقم الصفحة من الطلب صراحةً ──────────────────
        // paginate() يعتمد على Paginator::currentPageResolver المُقيَّد
        // (bound) في الحاوية، والذي قد لا يكون محدَّثاً في كل سياق
        // (اختبارات وحدة، أوامر artisan). لذلك نضبطه صراحةً من
        // الطلب المُمرَّر لنا — هكذا تكون الصفحة صحيحة دائماً.
        $page = 1;
        if ($request && $request->has('page')) {
            $page = max(1, (int) $request->input('page'));
        }

        $paginator = $query->paginate($perPage, ['*'], $pageName, $page);

        // map يُطبّق على عناصر الصفحة الحالية فقط لا على كل النتائج
        // (هذا مفتاح الأداء: لا نُحمّل 100 ألف كيان لنُحوّلهم).
        $items = $paginator->getCollection();
        if (isset($options['map']) && is_callable($options['map'])) {
            $map = $options['map'];
            $items = $items->map($map);
        }

        return [
            'data' => $items->values()->all(),
            'meta' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
        ];
    }

    /**
     * تحديد عدد الصفوف في الصفحة:
     *   1. من الطلب ?per_page= إن وُجد وكان رقماً منطقياً
     *   2. وإلا الافتراضي 25
     *   3. ويُقصّ دائماً إلى MAX_PER_PAGE (100) كإجراء أمان
     */
    public static function resolvePerPage(?Request $request): int
    {
        $default = self::DEFAULT_PER_PAGE;

        if (!$request || !$request->has('per_page')) {
            return $default;
        }

        $requested = (int) $request->input('per_page');

        // قيم غير منطقية (0 أو سالبة) ⇒ الافتراضي
        if ($requested <= 0) {
            return $default;
        }

        return min($requested, self::MAX_PER_PAGE);
    }

    /**
     * بناء meta من مُرقّم جاهز (LengthAwarePaginator) —
     * مفيد إن احتاج متحكم آخر البنية دون إعادة الاستعلام.
     */
    public static function metaOf(LengthAwarePaginator $paginator): array
    {
        return [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ];
    }
}

<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * سمة تطبيق الفلاتر والترتيب الآمن للأصول في قمرة القيادة
 *
 * تتولى تطبيق فلاتر الحالة، البحث النصي، فلاتر التصنيف والوسوم، والترتيب الآمن
 * مع توفير تخزين مؤقت داخل دورة الطلب (Request-level cache) لقوائم الأعمدة
 * لتفادي تكرار الاستعلامات على Schema::getColumnListing في PostgreSQL.
 */
trait AppliesAssetFilters
{
    /**
     * ذاكرة مؤقتة لأعمدة الجداول داخل نفس الطلب
     *
     * @var array<string, array<int, string>>
     */
    protected array $tableColumnsCache = [];

    /**
     * جلب أعمدة الجدول مع التخزين المؤقت للطلب
     *
     * @param string $table
     * @return array<int, string>
     */
    protected function getTableColumns(string $table): array
    {
        return $this->tableColumnsCache[$table] ??= Schema::getColumnListing($table);
    }

    /**
     * تطبيق فلتر الحالة والبحث على استعلام الأصل.
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @param  array<int, string>  $searchableColumns  الأعمدة التي يبحث فيها
     * @param  array<int, string>  $filterableColumns  الأعمدة التي تُفلتر بقيمتها
     * @return Builder
     */
    protected function applyAssetFilters(Builder $query, Request $request, array $searchableColumns = ['title'], array $filterableColumns = []): Builder
    {
        $table = $query->getModel()->getTable();
        $existing = $this->getTableColumns($table);

        // 1. فلتر الحالة: ?status=published
        $status = $request->query('status');
        if ($status && $status !== 'all') {
            if (in_array('status', $existing, true)) {
                $query->where('status', $status);
            }
        }

        // 2. البحث النصي: ?search=نص
        $search = $request->query('search');
        if ($search) {
            $query->where(function (Builder $q) use ($search, $searchableColumns, $existing) {
                foreach ($searchableColumns as $column) {
                    if (in_array($column, $existing, true)) {
                        $q->orWhere($column, 'ILIKE', '%' . $search . '%');
                    }
                }
            });
        }

        // 3. فلتر الأعمدة المباشرة والعلاقات: ?author=... إلخ
        foreach ($filterableColumns as $column) {
            $value = $request->query($column);
            if ($value && $value !== 'all') {
                if (in_array($column, ['category', 'tag'], true)) {
                    if (!Str::isUuid($value)) {
                        continue; // قيمة غير صالحة => يتم تجاهلها بهدوء
                    }

                    $relation = $column === 'category' ? 'categories' : 'tags';
                    $pivotTable = $column === 'category' ? 'categories' : 'tags';

                    $query->whereHas($relation, fn (Builder $q) => $q->where($pivotTable . '.id', $value));
                } elseif (in_array($column, $existing, true)) {
                    $query->where($column, $value);
                }
            }
        }

        return $query;
    }

    /**
     * تطبيق الترتيب الآمن على استعلام الأصل بناءً على قائمة بيضاء (whitelist).
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @param  array<string, string>  $sortMap  ['الأحدث' => 'created_at', ...]
     * @param  array<string, string>  $defaultDirection  الاتجاه الافتراضي لكل خيار
     * @return Builder
     */
    protected function applySort(Builder $query, Request $request, array $sortMap, array $defaultDirection = []): Builder
    {
        $sort = $request->query('sort');

        if (!$sort || !isset($sortMap[$sort])) {
            return $query->latest();
        }

        $column = $sortMap[$sort];
        $table = $query->getModel()->getTable();
        $existing = $this->getTableColumns($table);

        if (!in_array($column, $existing, true)) {
            return $query->latest();
        }

        $direction = $request->query('direction');
        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = $defaultDirection[$sort] ?? 'asc';
        }

        return $query->orderBy($column, $direction);
    }
}

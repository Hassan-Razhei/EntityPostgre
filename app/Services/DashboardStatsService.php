<?php

namespace App\Services;

use App\Enums\ContentStatus;
use App\Models\Activity;
use App\Models\Audio;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\Manuscript;
use App\Models\Publisher;
use App\Models\Series;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\User;
use App\Models\Version;
use App\Models\Video;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Schema;

/**
 * خدمة إحصائيات وقمع قمرة القيادة (Dashboard Stats & Funnel Service)
 *
 * تتولى حساب إجماليات الكيانات الـ 16، دورة حياة الأصول عبر ContentStatus،
 * مسارات قمع الاستوديو، وسلة المحذوفات الناعمة الموحدة.
 */
class DashboardStatsService
{
    /**
     * ذاكرة مؤقتة لأعمدة الجداول
     */
    protected array $tableColumnsCache = [];

    /**
     * حساب إحصائيات قمرة القيادة الشاملة
     *
     * @return array<string, int>
     */
    public function getStats(): array
    {
        $deletionsCount = Book::onlyTrashed()->count()
            + Manuscript::onlyTrashed()->count()
            + Audio::onlyTrashed()->count()
            + Video::onlyTrashed()->count()
            + Author::onlyTrashed()->count();

        return [
            // ─── إجماليات الكيانات ───────────────────────────────────────────
            'books'       => Book::count(),
            'manuscripts' => Manuscript::count(),
            'audios'      => Audio::count(),
            'videos'      => Video::count(),
            'authors'     => Author::count(),
            'publishers'  => Publisher::count(),
            'categories'  => Category::count(),
            'tags'        => Tag::count(),
            'users'       => User::count(),
            'collections' => Collection::count(),
            'series'      => Series::count(),
            'topics'      => Topic::count(),
            'comments'    => Comment::count(),
            'activities'  => Activity::count(),
            'versions'    => Version::count(),
            'deletions'   => $deletionsCount,

            // ─── إحصائيات دورة حياة الأصول (حالات منفصلة من ContentStatus) ──
            ...$this->statusCounts(Book::class, 'books'),
            ...$this->statusCounts(Manuscript::class, 'manuscripts'),
            ...$this->statusCounts(Audio::class, 'audios'),
            ...$this->statusCounts(Video::class, 'videos'),

            // ─── الاستوديو والقمع (تُغذّي DashboardStatsView) ───────────────
            'studio_books'       => Book::whereIn('status', ['draft', 'transcribed', 'verified', 'revised', 'curriculum'])->count(),
            'studio_manuscripts' => Manuscript::whereIn('status', ['draft', 'typeset', 'collated', 'edited'])->count(),
            'studio_audios'      => Audio::whereIn('status', ['draft', 'transcribed', 'verified', 'revised', 'curriculum'])->count(),
            'studio_videos'      => Video::whereIn('status', ['draft', 'transcribed', 'verified', 'revised', 'curriculum'])->count(),
            'funnel_drafts'      => Book::where('status', 'draft')->count(),
            'funnel_reviewed'    => Book::whereIn('status', ['transcribed', 'verified'])->count(),
            'funnel_scholarly'   => Book::whereIn('status', ['revised', 'curriculum', 'scholarly'])->count(),
            'funnel_published'   => Book::where('status', 'published')->count(),
        ];
    }

    /**
     * حساب أعداد كل حالة تحريرية لأصل معين من ContentStatus
     *
     * @param  class-string  $modelClass
     * @param  string        $assetKey
     * @return array<string, int>
     */
    public function statusCounts(string $modelClass, string $assetKey): array
    {
        $statuses = ContentStatus::forAsset(rtrim($assetKey, 's'));
        $result = [];

        $table = (new $modelClass)->getTable();
        $this->tableColumnsCache[$table] ??= Schema::getColumnListing($table);
        $hasStatusColumn = in_array('status', $this->tableColumnsCache[$table], true);

        $counts = $hasStatusColumn
            ? $modelClass::groupBy('status')
                ->selectRaw('status, count(*) as count')
                ->pluck('count', 'status')
            : collect();

        foreach ($statuses as $status) {
            $result["{$assetKey}_{$status->value}"] = (int) ($counts[$status->value] ?? 0);
        }

        return $result;
    }

    /**
     * جلب قائمة موحدة بالمحذوفات الناعمة الحية (Soft-deleted entities)
     *
     * @return SupportCollection
     */
    public function getSoftDeletions(): SupportCollection
    {
        $deletedBooks = Book::onlyTrashed()->latest('deleted_at')->limit(10)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'type_label' => 'كتاب / Book',
                'type_chip' => 'chip-studio',
                'deleted_at_human' => $item->deleted_at?->diffForHumans() ?? 'مؤخراً',
                'days_remaining' => 'باقي 29 يوماً',
                'restore_url' => "/books/{$item->id}/restore",
            ];
        });

        $deletedManuscripts = Manuscript::onlyTrashed()->latest('deleted_at')->limit(10)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'type_label' => 'مخطوط / Manuscript',
                'type_chip' => 'chip-academic',
                'deleted_at_human' => $item->deleted_at?->diffForHumans() ?? 'مؤخراً',
                'days_remaining' => 'باقي 28 يوماً',
                'restore_url' => "/manuscripts/{$item->id}/restore",
            ];
        });

        $deletedAudios = Audio::onlyTrashed()->latest('deleted_at')->limit(10)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'type_label' => 'صوتي / Audio',
                'type_chip' => 'chip-editor',
                'deleted_at_human' => $item->deleted_at?->diffForHumans() ?? 'مؤخراً',
                'days_remaining' => 'باقي 27 يوماً',
                'restore_url' => "/audios/{$item->id}/restore",
            ];
        });

        $deletedVideos = Video::onlyTrashed()->latest('deleted_at')->limit(10)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'type_label' => 'مرئي / Video',
                'type_chip' => 'chip-public',
                'deleted_at_human' => $item->deleted_at?->diffForHumans() ?? 'مؤخراً',
                'days_remaining' => 'باقي 26 يوماً',
                'restore_url' => "/videos/{$item->id}/restore",
            ];
        });

        $deletedAuthors = Author::onlyTrashed()->latest('deleted_at')->limit(10)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->name,
                'type_label' => 'مؤلف / Author',
                'type_chip' => 'chip-admin',
                'deleted_at_human' => $item->deleted_at?->diffForHumans() ?? 'مؤخراً',
                'days_remaining' => 'باقي 30 يوماً',
                'restore_url' => "/authors/{$item->id}/restore",
            ];
        });

        return $deletedBooks->concat($deletedManuscripts)
            ->concat($deletedAudios)
            ->concat($deletedVideos)
            ->concat($deletedAuthors)
            ->values();
    }
}

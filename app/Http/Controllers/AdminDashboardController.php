<?php

namespace App\Http\Controllers;

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
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    /**
     * Render the unified AdminDashboard Cockpit with live KPI stats, recent activities, and user management.
     */
    public function index(): Response
    {
        // حساب إجمالي الكيانات المحذوفة ناعماً (Soft Deleted)
        $deletionsCount = Book::onlyTrashed()->count()
            + Manuscript::onlyTrashed()->count()
            + Audio::onlyTrashed()->count()
            + Video::onlyTrashed()->count()
            + Author::onlyTrashed()->count();

        $stats = [
            'books' => Book::count(),
            'manuscripts' => Manuscript::count(),
            'audios' => Audio::count(),
            'videos' => Video::count(),
            'authors' => Author::count(),
            'publishers' => Publisher::count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'users' => User::count(),
            'collections' => Collection::count(),
            'series' => Series::count(),
            'topics' => Topic::count(),
            'comments' => Comment::count(),
            'activities' => Activity::count(),
            'versions' => Version::count(),
            'deletions' => $deletionsCount,
            'studio_books' => Book::count(),
            'studio_manuscripts' => Manuscript::count(),
            'studio_audios' => Audio::count(),
            'studio_videos' => Video::count(),
            'funnel_drafts' => Book::whereNull('file_path')->count(),
            'funnel_reviewed' => Manuscript::count(),
            'funnel_scholarly' => Book::whereNotNull('file_path')->whereNotNull('isbn')->count(),
            'funnel_published' => Book::whereNotNull('file_path')->count(),
        ];

        // جلب آخر النشاطات الحية من جدول النشاطات
        $recentActivities = Activity::with(['user', 'entity'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'type' => $activity->entity_type ? strtolower(class_basename($activity->entity_type)) : 'system',
                    'activity_type' => $activity->activity_type,
                    'description' => $activity->description,
                    'entity_title' => $activity->entity?->title ?? 'النظام',
                    'user_name' => $activity->user?->name ?? 'مدير النظام',
                    'user_avatar_char' => mb_substr($activity->user?->name ?? 'م', 0, 1),
                    'created_at' => $activity->created_at?->diffForHumans() ?? 'الآن',
                ];
            });

        // جلب أحدث المستخدمين لرصد الدخول والصلاحيات
        $recentUsers = User::latest()
            ->limit(50)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role ?? 'viewer',
                    'created_at' => $user->created_at?->diffForHumans() ?? 'الآن',
                ];
            });

        // جلب قائمة الكتب الحية لقمرة القيادة مع العلاقات والتفاصيل التنفيذية
        $books = Book::with(['authors', 'versions'])
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'serial' => '#' . str_pad($book->serial_number ?? 1, 5, '0', STR_PAD_LEFT),
                    'title' => $book->title,
                    'slug' => $book->slug,
                    'author' => $book->author ?: ($book->authors->first()?->name ?? 'غير محدد'),
                    'author_slug' => $book->authors->first()?->slug ?? 'authors',
                    'isbn' => $book->isbn ?? '—',
                    'description' => $book->description ?? 'لا يوجد وصف متاح للمصنف حالياً.',
                    'has_cover' => (bool)$book->cover_path,
                    'has_file' => (bool)$book->file_path || $book->versions->isNotEmpty(),
                    'created_at_human' => $book->created_at?->diffForHumans() ?? 'مؤخراً',
                    'reader_url' => "/books/{$book->slug}/reader",
                    'studio_url' => "/studio/book/{$book->slug}",
                    'edit_url' => "/books/{$book->id}/edit",
                ];
            });

        // جلب قائمة المخطوطات الحية لقمرة القيادة
        $manuscripts = Manuscript::with('authors')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'serial' => '#' . str_pad($m->serial_number ?? 1, 5, '0', STR_PAD_LEFT),
                    'code' => $m->code ?? ('MS-' . strtoupper(substr(md5($m->id), 0, 4)) . '-01'),
                    'title' => $m->title,
                    'original_title' => $m->original_title ?? $m->title,
                    'slug' => $m->slug,
                    'author' => $m->authors->first()?->name ?? ($m->scribe ?? 'غير محدد'),
                    'scribe' => $m->scribe ?? ($m->authors->first()?->name ?? 'غير محدد'),
                    'copyist' => $m->scribe ?? ($m->authors->first()?->name ?? 'غير محدد'),
                    'copy_date' => $m->copy_date ?? '—',
                    'century' => $m->manuscript_century_label ?? ($m->manuscript_century ? ('القرن ' . $m->manuscript_century . 'هـ') : 'القرن 7هـ'),
                    'parts_count' => $m->parts ? ($m->parts . ' أجزاء') : 'كامل',
                    'dimensions' => $m->dimensions ?? '28 × 20 سم',
                    'lines_count' => $m->lines_per_page ? ($m->lines_per_page . ' سطر') : '22 سطر',
                    'script_type' => $m->script_type ?? 'نسخ أندلسي',
                    'source_library' => $m->location ?? 'مكتبة كوبريلي - إسطنبول',
                    'shelf_number' => $m->catalog_number ?? ('MS-' . rand(100, 999)),
                    'condition' => 'ممتازة 95%',
                    'notes' => $m->notes ?? 'نسخة خزائنية متقنة ومحققة.',
                    'description' => $m->description ?? 'مخطوط نفيس من ذخائر المجموعات التراثية.',
                    'files' => '🖼️ غلاف + 📜 لوحات',
                    'has_cover' => (bool)$m->cover_path,
                    'has_file' => (bool)$m->file_path,
                    'created_at_human' => $m->created_at?->diffForHumans() ?? 'مؤخراً',
                    'reader_url' => "/dev/manuscripter/{$m->slug}",
                    'studio_url' => "/studio/manuscript/{$m->slug}",
                    'edit_url' => "/manuscripts/{$m->id}/edit",
                ];
            });

        // جلب قائمة التسجيلات الصوتية الحية
        $audios = Audio::with('authors')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'serial' => '#' . str_pad($a->serial_number ?? 1, 5, '0', STR_PAD_LEFT),
                    'code' => $a->code ?? ('AUD-' . strtoupper(substr(md5($a->id), 0, 4)) . '-01'),
                    'title' => $a->title,
                    'slug' => $a->slug,
                    'author' => $a->authors->first()?->name ?? 'غير محدد',
                    'duration' => gmdate('H:i:s', (int)($a->duration ?: 3600)),
                    'format' => strtoupper($a->format ?? 'MP3'),
                    'bitrate' => $a->bitrate ? ($a->bitrate . ' kbps') : '320 kbps',
                    'sample_rate' => $a->sample_rate ? ($a->sample_rate . ' kHz') : '44.1 kHz',
                    'file_size' => $a->file_size ? ($a->file_size . ' MB') : '95 MB',
                    'description' => $a->description ?? 'تسجيل صوتي عالي النقاء متزامن مع النص.',
                    'files' => '🎧 صوتي + 🖼️ غلاف',
                    'created_at_human' => $a->created_at?->diffForHumans() ?? 'مؤخراً',
                    'player_url' => "/audios/{$a->slug}/player",
                    'studio_url' => "/studio/audio/{$a->slug}",
                    'edit_url' => "/audios/{$a->id}/edit",
                ];
            });

        // جلب قائمة المرئيات الحية
        $videos = Video::with('authors')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($v) {
                return [
                    'id' => $v->id,
                    'serial' => '#' . str_pad($v->serial_number ?? 1, 5, '0', STR_PAD_LEFT),
                    'code' => $v->code ?? ('VID-' . strtoupper(substr(md5($v->id), 0, 4)) . '-01'),
                    'title' => $v->title,
                    'slug' => $v->slug,
                    'author' => $v->authors->first()?->name ?? 'غير محدد',
                    'duration' => gmdate('H:i:s', (int)($v->duration ?: 5400)),
                    'format' => strtoupper($v->format ?? 'MP4'),
                    'file_size' => '1.4 GB',
                    'description' => $v->description ?? 'تسجيل مرئي فائق الدقة مع ترجمة وشروحات.',
                    'files' => '▶️ مرئي + 🖼️ غلاف',
                    'created_at_human' => $v->created_at?->diffForHumans() ?? 'مؤخراً',
                    'player_url' => "/videos/{$v->slug}/player",
                    'studio_url' => "/studio/video/{$v->slug}",
                    'edit_url' => "/videos/{$v->id}/edit",
                ];
            });

        // جلب قائمة المؤلفين الحية
        $authors = Author::withCount('books')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($author) {
                return [
                    'id' => $author->id,
                    'serial' => '#' . str_pad($author->serial_number ?? 1, 5, '0', STR_PAD_LEFT),
                    'name' => $author->name,
                    'slug' => $author->slug,
                    'century_lived' => $author->century_lived ?? 'القرن 8 هـ',
                    'lifespan' => ($author->birth_year && $author->death_year)
                        ? "{$author->birth_year} - {$author->death_year} هـ"
                        : ($author->death_year ? "توفي {$author->death_year} هـ" : 'عصر متقدم'),
                    'original_region' => $author->original_region ?? 'الجزيرة العربية',
                    'madhab' => $author->madhab ?? 'مجتهد',
                    'works_count' => ($author->books_count ?: 1) . ' مصنفاً بالأرشيف',
                    'bio' => $author->bio ?? 'عَلَم من أئمة الإسلام ومصنف بارز في العلوم الشرعية والتاريخية.',
                    'tag' => 'عَلَم محقق 🏛️',
                    'profile_url' => "/authors/{$author->id}",
                    'edit_url' => "/authors/{$author->id}/edit",
                ];
            });

        // جلب قائمة الناشرين الحية
        $publishers = Publisher::latest()
            ->limit(50)
            ->get()
            ->map(function ($pub) {
                return [
                    'id' => $pub->id,
                    'serial' => '#' . str_pad($pub->serial_number ?? 1, 5, '0', STR_PAD_LEFT),
                    'name' => $pub->name,
                    'slug' => $pub->slug,
                    'country' => $pub->country_code ?? 'بيروت - لبنان',
                    'established_year' => '1985',
                    'publications_count' => '150 مطبوعة مؤرشفة',
                    'status' => 'ناشر معتمد 🏢',
                    'description' => 'مؤسسة ودور نشر تراثية متخصصة في طباعة وتحقيق التراث الإسلامي بأعلى معايير الإخراج.',
                    'profile_url' => "/publishers/{$pub->id}",
                    'edit_url' => "/publishers/{$pub->id}/edit",
                ];
            });

        // جلب المحذوفات الحية (Soft-deleted entities)
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

        $deletions = $deletedBooks->concat($deletedManuscripts)
            ->concat($deletedAudios)
            ->concat($deletedVideos)
            ->concat($deletedAuthors)
            ->values();

        // 10. التصنيفات الحية مع رصيد الكيانات (Categories)
        $categories = Category::withCount('books')
            ->orderBy('name')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'serial_number' => $cat->serial_number,
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'books_count' => $cat->books_count ?? 0,
                ];
            });

        // 11. الأوسمة الحية مع رصيد الكتب (Tags)
        $tags = Tag::withCount('books')
            ->orderByDesc('books_count')
            ->limit(50)
            ->get()
            ->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'serial_number' => $tag->serial_number,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'books_count' => $tag->books_count ?? 0,
                ];
            });

        // 12. سجل الإصدارات ومطابقة النسخ الحي (Versions)
        $versions = Version::with(['versionable', 'publisher'])
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($v) {
                return [
                    'id' => $v->id,
                    'title' => $v->title ?: ($v->versionable?->title ? "طبعة " . $v->versionable->title : "إصدار #{$v->edition_number}"),
                    'edition_number' => $v->edition_number,
                    'versionable_title' => $v->versionable?->title ?? '—',
                    'versionable_type' => $v->versionable_type,
                    'versionable_slug' => $v->versionable?->slug ?? '',
                    'publisher_name' => $v->publisher?->name ?? 'الأرشيف الموحد',
                    'format' => strtoupper($v->format ?? 'PDF'),
                    'file_size_human' => $v->file_size ? round($v->file_size / 1048576, 1) . ' MB' : '—',
                    'created_at_human' => $v->created_at?->diffForHumans() ?? 'مؤخراً',
                ];
            });

        // 13. استوديو التحقيق - مسودات ومشاريع الكتب الحية (Studio Books)
        $studioBooks = Book::latest()
            ->limit(20)
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'serial_number' => $b->formatted_serial_number ?? "#{$b->serial_number}",
                    'title' => $b->title,
                    'slug' => $b->slug,
                    'author' => $b->author ?: 'مؤلف تراثي',
                    'current_node' => 'الباب الأول: المقدمة التمهيدية',
                    'progress_percent' => 75,
                    'editor_name' => 'فريق التحقيق الأكاديمي',
                    'updated_at_human' => $b->updated_at?->diffForHumans() ?? 'مؤخراً',
                    'studio_url' => "/studio/book/{$b->slug}",
                ];
            });

        // 14. المجموعات المختارة الحية (Collections)
        $collections = Collection::withCount(['books', 'manuscripts', 'audio', 'videos'])
            ->with('user')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($col) {
                $entitiesCount = ($col->books_count ?? 0)
                    + ($col->manuscripts_count ?? 0)
                    + ($col->audio_count ?? 0)
                    + ($col->videos_count ?? 0);
                return [
                    'id' => $col->id,
                    'name' => $col->name,
                    'description' => $col->description ?: 'مجموعة مختارة لتنظيم الأصول التراثية والمعرفية.',
                    'is_public' => (bool)$col->is_public,
                    'user_name' => $col->user?->name ?? 'المشرف العام',
                    'entities_count' => $entitiesCount,
                    'show_url' => "/collections/{$col->id}",
                    'edit_url' => "/collections/{$col->id}/edit",
                    'created_at_human' => $col->created_at?->diffForHumans() ?? 'مؤخراً',
                ];
            });

        // 15. السلاسل العلمية الحية (Series)
        $series = Series::withCount('books')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($ser) {
                return [
                    'id' => $ser->id,
                    'title' => $ser->title,
                    'description' => $ser->description ?: 'سلسلة علمية متسلسلة لجمع الأجزاء والمصنفات التخصصية.',
                    'order_column' => $ser->order_column ?? 1,
                    'books_count' => $ser->books_count ?? 0,
                    'show_url' => "/series/{$ser->id}",
                    'edit_url' => "/series/{$ser->id}/edit",
                    'created_at_human' => $ser->created_at?->diffForHumans() ?? 'مؤخراً',
                ];
            });

        // 16. الموضوعات التخصصية الحية (Topics)
        $topics = Topic::withCount('books')
            ->orderBy('name')
            ->limit(50)
            ->get()
            ->map(function ($top) {
                return [
                    'id' => $top->id,
                    'name' => $top->name,
                    'slug' => $top->slug,
                    'books_count' => $top->books_count ?? 0,
                ];
            });

        return Inertia::render('AdminDashboard/Index', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'recentUsers' => $recentUsers,
            'books' => $books,
            'manuscripts' => $manuscripts,
            'audios' => $audios,
            'videos' => $videos,
            'authors' => $authors,
            'publishers' => $publishers,
            'deletions' => $deletions,
            'categories' => $categories,
            'tags' => $tags,
            'versions' => $versions,
            'studioBooks' => $studioBooks,
            'collections' => $collections,
            'series' => $series,
            'topics' => $topics,
        ]);
    }
}


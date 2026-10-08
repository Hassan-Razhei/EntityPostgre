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
            'comments' => Comment::count(),
            'activities' => Activity::count(),
            'versions' => Version::count(),
            'deletions' => $deletionsCount,
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
            ->limit(10)
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

        return Inertia::render('AdminDashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'recentUsers' => $recentUsers,
            'books' => $books,
        ]);
    }
}

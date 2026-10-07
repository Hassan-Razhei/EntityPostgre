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

class SuperAdminDashboardController extends Controller
{
    public function index(): Response
    {
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
            'deletions' => 0,
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

        return Inertia::render('AdminDashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
        ]);
    }
}

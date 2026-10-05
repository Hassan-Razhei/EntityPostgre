<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Audio;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Manuscript;
use App\Models\Tag;
use App\Models\Video;
use App\Models\Note;
use App\Models\Deletion;
use App\Models\Collection;
use App\Models\Series;
use App\Observers\EntityAuditObserver;
use App\Observers\EntityCacheObserver;
use App\Observers\EntityLifecycleObserver;
use App\Observers\EntityContentObserver;
use App\Models\BookChild;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Entity;
use App\Models\User;
use App\Policies\EntityPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // app/Providers/AppServiceProvider.php
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // العبور المركزي للمدير العام مع حماية حصانة سجلات التدقيق (Immutability)
        Gate::before(function (\App\Models\User $user, string $ability) {
            if (in_array($ability, ['delete-audit-log', 'update-audit-log'], true)) {
                return null;
            }

            return $user->isSuperAdmin() ? true : null;
        });

        Gate::policy(Entity::class, EntityPolicy::class);
        Gate::policy(Book::class, EntityPolicy::class);
        Gate::policy(Video::class, EntityPolicy::class);
        Gate::policy(Audio::class, EntityPolicy::class);
        Gate::policy(Manuscript::class, EntityPolicy::class);
        Gate::policy(\App\Models\Author::class, EntityPolicy::class);
        Gate::policy(\App\Models\Category::class, EntityPolicy::class);
        Gate::policy(\App\Models\Tag::class, EntityPolicy::class);
        Gate::policy(\App\Models\Publisher::class, EntityPolicy::class);
        Gate::policy(\App\Models\Series::class, EntityPolicy::class);
        Gate::policy(\App\Models\Topic::class, EntityPolicy::class);

        Book::flushEventListeners();
        Video::flushEventListeners();
        Audio::flushEventListeners();
        Manuscript::flushEventListeners();


        $this->registerMorphMap();
        $this->registerObservers();
        $this->registerEventListeners();
        $this->registerAuthorizationGates();
    }

    /**
     * تسجيل بوابات مصفوفة العمليات الـ 14 التشغيلية
     * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الثالث والسادس)
     */
    protected function registerAuthorizationGates(): void
    {
        // 1. تصفح الفهارس والبحث العام (متاح للجميع حتى الزائر)
        Gate::define('browse_catalog', fn (?User $user) => true);

        // 2. تشغيل وبث وسائط الكتب العامة (متاح للجميع حتى الزائر)
        Gate::define('stream_media', fn (?User $user) => true);

        // 3. حفظ مواضع القراءة والملاحظات (محظور على الزائر، متاح لكافة المسجلين)
        Gate::define('save_research_notes', function (?User $user) {
            return $user !== null && $user->role !== \App\Enums\UserRole::GUEST;
        });

        // 4. تصدير الاقتباسات والأبحاث بدقة عالية
        Gate::define('export_citations', function (?User $user) {
            return $user !== null && $user->canExportCitations();
        });

        // 5. استعراض المخطوطات والمسودات المقيدة
        Gate::define('view_restricted_drafts', function (?User $user) {
            return $user !== null && $user->canViewRestricted();
        });

        // 6. تفريغ النصوص ومطابقة المقاطع بالاستوديو
        Gate::define('transcribe_in_studio', function (?User $user) {
            return $user !== null && $user->canAccessStudio();
        });

        // 7. إدخال وتعديل البيانات الوصفية والوسوم
        Gate::define('curate_metadata', function (?User $user) {
            return $user !== null && $user->canCurateMetadata();
        });

        // 8. رفع وسائط جديدة على قرص media
        Gate::define('upload_media', function (?User $user) {
            return $user !== null && $user->canUploadMedia();
        });

        // 9. تحكيم وتدقيق النسخ وإيداع التقارير العلمية
        Gate::define('review_academically', function (?User $user) {
            return $user !== null && $user->canReviewAcademically();
        });

        // 10. اعتماد ونشر العمل وإتاحته للجمهور
        Gate::define('publish_entity', function (?User $user) {
            return $user !== null && $user->canPublish();
        });

        // 11. تجميد وحذف السجلات مؤقتاً (Soft Delete)
        Gate::define('soft_delete_records', function (?User $user) {
            return $user !== null && $user->canSoftDelete();
        });

        // 12. إدارة النسخ الاحتياطي ومزامنة الأقراص
        Gate::define('manage_backups_storage', function (?User $user) {
            return $user !== null && $user->canManageBackups();
        });

        // 13. الاطلاع على سجلات الأمان والتعديل (Audit)
        Gate::define('view_audit_logs', function (?User $user) {
            return $user !== null && $user->canViewAuditLogs();
        });

        // 14. تشغيل أوامر النظام السيادية وتعديل الرتب
        Gate::define('manage_system_commands', function (?User $user) {
            return $user !== null && $user->canManageSystem();
        });
    }

    /**
     * تسجيل morphMap للعلاقات البوليمورفية
     * هذا يحل مشكلة العلاقات مع Entity abstract class
     */
    protected function registerMorphMap(): void
    {
        Relation::morphMap([
            'book' => Book::class,
            'video' => Video::class,
            'audio' => Audio::class,
            'manuscript' => Manuscript::class,
            'tag' => Tag::class,
            'category' => Category::class,
            // إضافة النماذج الجديدة
            'activity' => Activity::class,
            'comment' => Comment::class,
            'note' => Note::class,
            'deletion' => Deletion::class,
            'collection' => Collection::class,
            'series' => Series::class,
            // New Models
            'author' => \App\Models\Author::class,
            'booker' => \App\Models\Booker::class,
            'publisher' => \App\Models\Publisher::class,
            'topic' => \App\Models\Topic::class,
            'shelf' => \App\Models\Shelf::class,
            'version' => \App\Models\Version::class,
            'content_node' => \App\Models\ContentNode::class,
            'book_child' => \App\Models\BookChild::class,
        ]);
    }

    /**
     * تسجيل الـ Observers
     */
    protected function registerObservers(): void
    {
        // إنشاء instances من الـ observers
        $lifecycleObserver = app(EntityLifecycleObserver::class);
        $auditObserver = app(EntityAuditObserver::class);
        $cacheObserver = app(EntityCacheObserver::class);
        $contentObserver = app(EntityContentObserver::class);

        // قائمة الموديلات التي تحتاج observers
        $entityModels = [
            Book::class,
            Video::class,
            Audio::class,
            Manuscript::class,
        ];

        // تسجيل observers لكل موديل
        foreach ($entityModels as $modelClass) {
            $modelClass::observe($lifecycleObserver);
            $modelClass::observe($auditObserver);
            $modelClass::observe($cacheObserver);
            $modelClass::observe($contentObserver);
        }

        // تسجيل cache observer فقط لـ Tag و Category
        Tag::observe($cacheObserver);
        Category::observe($cacheObserver);


    }

    /**
     * تسجيل Event Listeners لعمليات Sync
     */
    protected function registerEventListeners(): void
    {
        // مراقبة عمليات sync للعلاقات
        Event::listen('eloquent.attached: *', function ($event, $data) {
            if (count($data) >= 3) {
                $model = $data[0];
                $relation = $data[1];
                $ids = $data[2] ?? [];

                $observer = new EntityCacheObserver();
                $observer->invalidateRelationCaches($model);
            }
        });

        Event::listen('eloquent.detached: *', function ($event, $data) {
            if (count($data) >= 3) {
                $model = $data[0];
                // $relation = $data[1];
                // $ids = $data[2] ?? [];

                $observer = new EntityCacheObserver();
                $observer->invalidateRelationCaches($model);
            }
        });

        Event::listen('eloquent.synced: *', function ($event, $data) {
            if (count($data) >= 3) {
                $model = $data[0];
                // $relation = $data[1];
                // $changes = $data[2] ?? [];

                $observer = new EntityCacheObserver();
                $observer->invalidateRelationCaches($model);
            }
        });
    }
}

<?php

namespace App\Enums;

/**
 * التعداد الهرمي للأدوار الـ 12 في منصة الأرشيف الرقمي الموحد
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md
 */
enum UserRole: string
{
    // 1. القطاع الإداري والتقني
    case SUPER_ADMIN = 'super_admin';
    case SYSTEM_AUDITOR = 'system_auditor';
    case BACKUP_OPERATOR = 'backup_operator';

    // 2. قطاع الاستوديو والتحرير والفهرسة
    case CHIEF_EDITOR = 'chief_editor';
    case EDITOR = 'editor';
    case CATALOGER = 'cataloger';
    case TRANSCRIBER = 'transcriber';

    // 3. القطاع الأكاديمي والبحثي
    case ACADEMIC_REVIEWER = 'academic_reviewer';
    case VERIFIED_RESEARCHER = 'verified_researcher';
    case RESEARCHER = 'researcher';

    // 4. قطاع الخدمة والعموم
    case SUBSCRIBER = 'subscriber';
    case GUEST = 'guest';

    /**
     * المسمى العربي الرسمي للدور
     */
    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'مدير النظام الشامل',
            self::SYSTEM_AUDITOR => 'مدقق ومراقب النظام',
            self::BACKUP_OPERATOR => 'مشغل النسخ الاحتياطي والتخزين',
            self::CHIEF_EDITOR => 'رئيس التحرير والاعتماد',
            self::EDITOR => 'محرر الاستوديو والوسائط',
            self::CATALOGER => 'مفهرس البيانات الوصفية',
            self::TRANSCRIBER => 'ناسخ ومفرّغ النصوص',
            self::ACADEMIC_REVIEWER => 'مُحكّم ومراجع علمي',
            self::VERIFIED_RESEARCHER => 'باحث أكاديمي موثّق',
            self::RESEARCHER => 'باحث مسجل',
            self::SUBSCRIBER => 'مشترك خدمات',
            self::GUEST => 'زائر عام',
        };
    }

    /**
     * الوزن الهرمي التنازلي لحساب وراثة الصلاحيات (من 100 إلى 0)
     */
    public function weight(): int
    {
        return match ($this) {
            self::SUPER_ADMIN => 100,
            self::SYSTEM_AUDITOR => 80,
            self::BACKUP_OPERATOR => 75,
            self::CHIEF_EDITOR => 70,
            self::EDITOR => 50,
            self::ACADEMIC_REVIEWER => 45,
            self::CATALOGER => 35,
            self::TRANSCRIBER => 30,
            self::VERIFIED_RESEARCHER => 25,
            self::RESEARCHER => 20,
            self::SUBSCRIBER => 15,
            self::GUEST => 0,
        };
    }

    /**
     * القطاع التشغيلي التابع له الدور
     */
    public function sector(): string
    {
        return match ($this) {
            self::SUPER_ADMIN, self::SYSTEM_AUDITOR, self::BACKUP_OPERATOR => 'القطاع الإداري والتقني',
            self::CHIEF_EDITOR, self::EDITOR, self::CATALOGER, self::TRANSCRIBER => 'قطاع الاستوديو والتحرير',
            self::ACADEMIC_REVIEWER, self::VERIFIED_RESEARCHER, self::RESEARCHER => 'القطاع الأكاديمي والبحثي',
            self::SUBSCRIBER, self::GUEST => 'قطاع الزوار والخدمات',
        };
    }

    /**
     * فئات ألوان Tailwind لشارة الرتبة في واجهات المستخدم
     */
    public function badgeColor(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'bg-red-500/10 text-red-500 border-red-500/20',
            self::SYSTEM_AUDITOR => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
            self::BACKUP_OPERATOR => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
            self::CHIEF_EDITOR => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            self::EDITOR => 'bg-teal-500/10 text-teal-400 border-teal-500/20',
            self::CATALOGER => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            self::TRANSCRIBER => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
            self::ACADEMIC_REVIEWER => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
            self::VERIFIED_RESEARCHER => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            self::RESEARCHER => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
            self::SUBSCRIBER => 'bg-violet-500/10 text-violet-400 border-violet-500/20',
            self::GUEST => 'bg-zinc-500/10 text-zinc-400 border-zinc-500/20',
        };
    }

    /**
     * التحقق مما إذا كان الدور يعادل أو يفوق دوراً آخر في الهرمية
     */
    public function isAtLeast(UserRole $role): bool
    {
        return $this->weight() >= $role->weight();
    }

    /**
     * التحقق من أهلية دخول استوديو التحقيق والتقطيع والمحاذاة
     */
    public function canAccessStudio(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::CHIEF_EDITOR, self::EDITOR, self::TRANSCRIBER], true);
    }

    /**
     * التحقق من أهلية فهرسة وتعديل البيانات الوصفية ودور النشر
     */
    public function canCurateMetadata(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::CHIEF_EDITOR, self::EDITOR, self::CATALOGER], true);
    }

    /**
     * التحقق من أهلية النشر العام للجمهور
     */
    public function canPublish(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::CHIEF_EDITOR], true);
    }

    /**
     * التحقق من أهلية تشغيل أوامر النظام السيادية
     */
    public function canManageSystem(): bool
    {
        return $this === self::SUPER_ADMIN;
    }

    /**
     * التحقق من أهلية إدارة وسائط النسخ الاحتياطي والتخزين
     */
    public function canManageBackups(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::BACKUP_OPERATOR], true);
    }

    /**
     * التحقق من أهلية مراقبة وتدقيق سجلات الأمان
     */
    public function canViewAuditLogs(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::SYSTEM_AUDITOR], true);
    }

    /**
     * التحقق من أهلية الاطلاع على المخطوطات والمسودات المقيدة
     */
    public function canViewRestricted(): bool
    {
        return in_array($this, [
            self::SUPER_ADMIN,
            self::SYSTEM_AUDITOR,
            self::CHIEF_EDITOR,
            self::EDITOR,
            self::ACADEMIC_REVIEWER,
            self::VERIFIED_RESEARCHER,
        ], true);
    }

    /**
     * تصدير الاقتباسات والأبحاث بدقة عالية
     */
    public function canExportCitations(): bool
    {
        return in_array($this, [
            self::SUPER_ADMIN,
            self::CHIEF_EDITOR,
            self::EDITOR,
            self::ACADEMIC_REVIEWER,
            self::VERIFIED_RESEARCHER,
            self::SUBSCRIBER,
        ], true);
    }

    /**
     * رفع وسائط جديدة على قرص media
     */
    public function canUploadMedia(): bool
    {
        return in_array($this, [
            self::SUPER_ADMIN,
            self::CHIEF_EDITOR,
            self::EDITOR,
        ], true);
    }

    /**
     * تحكيم وتدقيق النسخ وإيداع التقارير العلمية
     */
    public function canReviewAcademically(): bool
    {
        return in_array($this, [
            self::SUPER_ADMIN,
            self::CHIEF_EDITOR,
            self::ACADEMIC_REVIEWER,
        ], true);
    }

    /**
     * تجميد وحذف السجلات مؤقتاً (Soft Delete)
     */
    public function canSoftDelete(): bool
    {
        return in_array($this, [
            self::SUPER_ADMIN,
            self::CHIEF_EDITOR,
        ], true);
    }
}

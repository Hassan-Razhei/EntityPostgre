<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Enums\UserRole;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property UserRole $role
 * @property bool $is_active
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * Default values for model attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role' => UserRole::GUEST->value,
        'is_active' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_studio_type',
        'last_studio_slug',
        'last_studio_child_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * هل المستخدم مدير عام ذو سيادة مطلقة؟
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SUPER_ADMIN;
    }

    /**
     * فحص ما إذا كان المستخدم يمتلك دوراً أو أدواراً معينة
     *
     * @param UserRole|string ...$roles
     */
    public function hasRole(UserRole|string ...$roles): bool
    {
        if ($this->role === null) {
            return false;
        }

        foreach ($roles as $role) {
            $roleValue = $role instanceof UserRole ? $role->value : $role;
            if ($this->role->value === $roleValue) {
                return true;
            }
        }

        return false;
    }

    /**
     * فحص ما إذا كان دور المستخدم يعادل أو يفوق وزناً هرمياً معيناً
     */
    public function isAtLeast(UserRole $role): bool
    {
        return $this->role !== null && $this->role->isAtLeast($role);
    }

    /**
     * التحقق من أهلية دخول الاستوديو
     */
    public function canAccessStudio(): bool
    {
        return $this->role !== null && $this->role->canAccessStudio();
    }

    /**
     * التحقق من أهلية فهرسة وتعديل البيانات الوصفية
     */
    public function canCurateMetadata(): bool
    {
        return $this->role !== null && $this->role->canCurateMetadata();
    }

    /**
     * التحقق من أهلية النشر
     */
    public function canPublish(): bool
    {
        return $this->role !== null && $this->role->canPublish();
    }

    /**
     * التحقق من أهلية تصدير الاقتباسات بدقة عالية
     */
    public function canExportCitations(): bool
    {
        return $this->role !== null && $this->role->canExportCitations();
    }

    /**
     * التحقق من أهلية استعراض المسودات والمخطوطات المقيدة
     */
    public function canViewRestricted(): bool
    {
        return $this->role !== null && $this->role->canViewRestricted();
    }

    /**
     * التحقق من أهلية رفع الوسائط
     */
    public function canUploadMedia(): bool
    {
        return $this->role !== null && $this->role->canUploadMedia();
    }

    /**
     * التحقق من أهلية التحكيم العلمي
     */
    public function canReviewAcademically(): bool
    {
        return $this->role !== null && $this->role->canReviewAcademically();
    }

    /**
     * التحقق من أهلية الحذف المؤقت
     */
    public function canSoftDelete(): bool
    {
        return $this->role !== null && $this->role->canSoftDelete();
    }

    /**
     * التحقق من أهلية إدارة النسخ الاحتياطي
     */
    public function canManageBackups(): bool
    {
        return $this->role !== null && $this->role->canManageBackups();
    }

    /**
     * التحقق من أهلية الاطلاع على سجلات الأمان
     */
    public function canViewAuditLogs(): bool
    {
        return $this->role !== null && $this->role->canViewAuditLogs();
    }

    /**
     * التحقق من أهلية إدارة أوامر النظام
     */
    public function canManageSystem(): bool
    {
        return $this->role !== null && $this->role->canManageSystem();
    }
}

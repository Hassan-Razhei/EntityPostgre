<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

/**
 * سياسة الكيانات والمصنفات والأعمال الرقمية
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الثالث: سياسات)
 */
class EntityPolicy
{
    /**
     * تصفح واستعراض الفهارس العامة
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * استعراض الكيان (عام للمنشور، ومقيد للمسودات والمخطوطات الخاصة)
     */
    public function view(?User $user, $model): bool
    {
        if (! empty($model->is_restricted)) {
            return $user !== null && ($user->isAtLeast(UserRole::VERIFIED_RESEARCHER) || $user->canAccessStudio());
        }

        return true;
    }

    /**
     * إنشاء مصنفات أو كيانات جديدة
     */
    public function create(User $user): bool
    {
        return $user->canCurateMetadata() || $user->canAccessStudio();
    }

    /**
     * تعديل بيانات الكيان والمحتوى
     */
    public function update(User $user, $model): bool
    {
        return $user->canCurateMetadata() || $user->canAccessStudio();
    }

    /**
     * تجميد أو حذف الكيان مؤقتاً (Soft Delete) - محصور برئيس التحرير والمدير العام
     */
    public function delete(User $user, $model): bool
    {
        return $user->hasRole(UserRole::CHIEF_EDITOR, UserRole::SUPER_ADMIN);
    }

    /**
     * استرجاع الكيان المحذوف مؤقتاً
     */
    public function restore(User $user, $model): bool
    {
        return $user->hasRole(UserRole::CHIEF_EDITOR, UserRole::SUPER_ADMIN);
    }

    /**
     * الحذف النهائي الجذري - محصور حصراً بالمدير العام
     */
    public function forceDelete(User $user, $model): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * اعتماد ونشر المصنف للجمهور - محصور برئيس التحرير والمدير العام
     */
    public function publish(User $user, $model): bool
    {
        return $user->canPublish();
    }

    /**
     * أهلية دخول الاستوديو ومحاذاة المقاطع واللوحات
     */
    public function accessStudio(User $user, $model): bool
    {
        return $user->canAccessStudio();
    }
}

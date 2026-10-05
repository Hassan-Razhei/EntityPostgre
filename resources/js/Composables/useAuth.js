import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

/**
 * Composable لإدارة وفحص الهوية والصلاحيات التفاعلية في Vue 3
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الخامس: سلاسة)
 */
export function useAuth() {
    const page = usePage();

    const user = computed(() => page.props.auth?.user ?? null);
    const canMatrix = computed(() => page.props.auth?.user?.can ?? {});

    /**
     * فحص صلاحية معينة من مصفوفة أذونات المستخدم
     * @param {string} ability
     * @returns {boolean}
     */
    const can = (ability) => Boolean(canMatrix.value[ability]);

    /**
     * فحص ما إذا كان المستخدم يملك واحداً من الأدوار المحددة
     * @param {...string} roles
     * @returns {boolean}
     */
    const hasRole = (...roles) => {
        if (!user.value?.role) return false;
        return roles.includes(user.value.role);
    };

    /**
     * فحص ما إذا كان وزن رتبة المستخدم يعادل أو يفوق وزناً محدداً
     * @param {number|object} minWeight
     * @returns {boolean}
     */
    const isAtLeast = (minWeight) => {
        if (!user.value) return false;
        const weight = typeof minWeight === 'number' ? minWeight : (minWeight?.weight ?? 0);
        return (user.value.role_weight ?? 0) >= weight;
    };

    /**
     * هل المستخدم زائر غير مسجل؟
     */
    const isGuest = computed(() => !user.value);

    /**
     * هل المستخدم يحمل رتبة مدير النظام الشامل؟
     */
    const isSuperAdmin = computed(() => user.value?.role === 'super_admin');

    /**
     * هل المستخدم مؤهل لدخول استوديو التحرير والمحاذاة؟
     */
    const canAccessStudio = computed(() => Boolean(canMatrix.value.access_studio));

    return {
        user,
        can,
        hasRole,
        isAtLeast,
        isGuest,
        isSuperAdmin,
        canAccessStudio,
    };
}

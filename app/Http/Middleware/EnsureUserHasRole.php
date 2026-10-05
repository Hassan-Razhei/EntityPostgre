<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * حاجز التحقق من رتبة وصلاحية المستخدم
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الرابع: مناطق ⬅️ فحواجز)
 */
class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // 1. إذا كان الزائر غير مسجل
        if (! $user) {
            if ($request->expectsJson()) {
                abort(401, 'يجب تسجيل الدخول أولاً للوصول إلى هذا القسم.');
            }

            return redirect()->guest(route('login'));
        }

        // 2. تجميع وتفكيك الرتب المسموح بها (يدعم الفواصل role:editor,chief_editor)
        $allowedRoles = [];
        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $role) {
                $trimmed = trim($role);
                if ($trimmed !== '') {
                    $allowedRoles[] = $trimmed;
                }
            }
        }

        $userRole = $user->role instanceof UserRole ? $user->role->value : (string) $user->role;

        // 3. التحقق من تطابق الرتبة
        if (! in_array($userRole, $allowedRoles, true)) {
            $userRoleLabel = $user->role instanceof UserRole ? $user->role->label() : ($user->role ?? 'غير محدد');
            abort(403, "عذراً، ليس لديك الصلاحية الكافية للوصول إلى هذا القسم. رتبتك الحالية هي: {$userRoleLabel}.");
        }

        return $next($request);
    }
}

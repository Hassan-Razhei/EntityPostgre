<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * حاجز التحقق من نشاط الحساب وطرد الحسابات المجمدة
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الثاني + الرابع)
 */
class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->is_active) {
            Auth::logout();

            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            abort(403, 'تم تجميد هذا الحساب، يرجى مراجعة إدارة المنظومة.');
        }

        return $next($request);
    }
}

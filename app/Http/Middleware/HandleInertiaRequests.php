<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        if (app()->environment('testing')) {
        return null;
    }
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $role = $user?->role;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role?->value,
                    'role_label' => $role?->label(),
                    'role_weight' => $role?->weight(),
                    'badge_color' => $role?->badgeColor(),
                    'is_active' => (bool) $user->is_active,
                    'can' => [
                        'access_studio' => $role?->canAccessStudio() ?? false,
                        'curate_metadata' => $role?->canCurateMetadata() ?? false,
                        'publish' => $role?->canPublish() ?? false,
                        'system_commands' => $role?->canManageSystem() ?? false,
                        'manage_backups' => $role?->canManageBackups() ?? false,
                        'view_audit_logs' => $role?->canViewAuditLogs() ?? false,
                        'view_restricted' => $role?->canViewRestricted() ?? false,
                    ],
                ] : null,
            ],
        ];
    }
}

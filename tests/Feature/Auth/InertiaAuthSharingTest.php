<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص تكامل وحقن الهوية والصلاحيات عبر Inertia لكافة الأدوار الـ 12
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الخامس: تكامل الواجهات)
 */
class InertiaAuthSharingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shares_null_user_for_unauthenticated_guests(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Auth/Login')
                ->where('auth.user', null)
            );
    }

    #[Test]
    public function it_shares_user_without_sensitive_credentials(): void
    {
        $user = User::factory()->superAdmin()->create([
            'name' => 'الحسن رضي',
            'email' => 'hassan@archive.org',
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('auth.user.id', $user->id)
                ->where('auth.user.name', 'الحسن رضي')
                ->where('auth.user.email', 'hassan@archive.org')
                ->where('auth.user.role', 'super_admin')
                ->where('auth.user.role_label', 'مدير النظام الشامل')
                ->where('auth.user.role_weight', 100)
                ->where('auth.user.badge_color', 'bg-red-500/10 text-red-500 border-red-500/20')
                ->where('auth.user.is_active', true)
                ->missing('auth.user.password')
                ->missing('auth.user.remember_token')
            );
    }

    #[Test]
    #[DataProvider('twelveRolesCapabilitiesProvider')]
    public function it_shares_exact_permission_matrix_for_each_of_the_twelve_roles(
        UserRole $role,
        array $expectedCapabilities
    ): void {
        $user = User::factory()->withRole($role)->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->where('auth.user.role', $role->value)
                ->where('auth.user.can.access_studio', $expectedCapabilities['access_studio'])
                ->where('auth.user.can.curate_metadata', $expectedCapabilities['curate_metadata'])
                ->where('auth.user.can.publish', $expectedCapabilities['publish'])
                ->where('auth.user.can.system_commands', $expectedCapabilities['system_commands'])
                ->where('auth.user.can.manage_backups', $expectedCapabilities['manage_backups'])
                ->where('auth.user.can.view_audit_logs', $expectedCapabilities['view_audit_logs'])
                ->where('auth.user.can.view_restricted', $expectedCapabilities['view_restricted'])
            );
    }

    /**
     * مزود بيانات مصفوفة الصلاحيات لجميع الأدوار الـ 12 بلا استثناء
     */
    public static function twelveRolesCapabilitiesProvider(): array
    {
        return [
            // 1. القطاع الإداري والتقني
            '1. مدير النظام الشامل (super_admin)' => [
                UserRole::SUPER_ADMIN,
                [
                    'access_studio' => true,
                    'curate_metadata' => true,
                    'publish' => true,
                    'system_commands' => true,
                    'manage_backups' => true,
                    'view_audit_logs' => true,
                    'view_restricted' => true,
                ],
            ],
            '2. مدقق ومراقب النظام (system_auditor)' => [
                UserRole::SYSTEM_AUDITOR,
                [
                    'access_studio' => false,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => true,
                    'view_restricted' => true,
                ],
            ],
            '3. مشغل النسخ الاحتياطي (backup_operator)' => [
                UserRole::BACKUP_OPERATOR,
                [
                    'access_studio' => false,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => true,
                    'view_audit_logs' => false,
                    'view_restricted' => true,
                ],
            ],

            // 2. قطاع الاستوديو والتحرير والفهرسة
            '4. رئيس التحرير والاعتماد (chief_editor)' => [
                UserRole::CHIEF_EDITOR,
                [
                    'access_studio' => true,
                    'curate_metadata' => true,
                    'publish' => true,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => true,
                ],
            ],
            '5. محرر الاستوديو والوسائط (editor)' => [
                UserRole::EDITOR,
                [
                    'access_studio' => true,
                    'curate_metadata' => true,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => true,
                ],
            ],
            '6. مُحكّم ومراجع علمي (academic_reviewer)' => [
                UserRole::ACADEMIC_REVIEWER,
                [
                    'access_studio' => false,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => true,
                ],
            ],
            '7. مفهرس البيانات الوصفية (cataloger)' => [
                UserRole::CATALOGER,
                [
                    'access_studio' => false,
                    'curate_metadata' => true,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => true,
                ],
            ],
            '8. ناسخ ومفرّغ النصوص (transcriber)' => [
                UserRole::TRANSCRIBER,
                [
                    'access_studio' => true,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => true,
                ],
            ],

            // 3. القطاع الأكاديمي والبحثي
            '9. باحث موثّق ومتقدم (verified_researcher)' => [
                UserRole::VERIFIED_RESEARCHER,
                [
                    'access_studio' => false,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => true,
                ],
            ],
            '10. باحث مسجل (researcher)' => [
                UserRole::RESEARCHER,
                [
                    'access_studio' => false,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => false,
                ],
            ],

            // 4. قطاع الخدمة والعموم
            '11. مشترك خدمات (subscriber)' => [
                UserRole::SUBSCRIBER,
                [
                    'access_studio' => false,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => false,
                ],
            ],
            '12. زائر عام (guest)' => [
                UserRole::GUEST,
                [
                    'access_studio' => false,
                    'curate_metadata' => false,
                    'publish' => false,
                    'system_commands' => false,
                    'manage_backups' => false,
                    'view_audit_logs' => false,
                    'view_restricted' => false,
                ],
            ],
        ];
    }
}

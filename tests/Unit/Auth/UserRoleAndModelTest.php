<?php

namespace Tests\Unit\Auth;

use App\Enums\UserRole;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص وحدة الأدوار وموديل المستخدم والحصانات
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md
 */
class UserRoleAndModelTest extends TestCase
{
    #[Test]
    public function it_has_all_twelve_roles_with_correct_backed_values(): void
    {
        $cases = UserRole::cases();
        $this->assertCount(12, $cases, 'يجب أن يحتوي الـ Enum على 12 دوراً بالضبط');

        $expectedRoles = [
            'super_admin',
            'system_auditor',
            'backup_operator',
            'chief_editor',
            'editor',
            'cataloger',
            'transcriber',
            'academic_reviewer',
            'verified_researcher',
            'researcher',
            'subscriber',
            'guest',
        ];

        $actualRoles = array_map(fn (UserRole $role) => $role->value, $cases);
        $this->assertEqualsCanonicalizing($expectedRoles, $actualRoles);
    }

    #[Test]
    public function it_has_correct_hierarchy_weights_and_capabilities(): void
    {
        // 1. فحص الأوزان الهرمية
        $this->assertSame(100, UserRole::SUPER_ADMIN->weight());
        $this->assertSame(80, UserRole::SYSTEM_AUDITOR->weight());
        $this->assertSame(75, UserRole::BACKUP_OPERATOR->weight());
        $this->assertSame(70, UserRole::CHIEF_EDITOR->weight());
        $this->assertSame(50, UserRole::EDITOR->weight());
        $this->assertSame(45, UserRole::ACADEMIC_REVIEWER->weight());
        $this->assertSame(35, UserRole::CATALOGER->weight());
        $this->assertSame(30, UserRole::TRANSCRIBER->weight());
        $this->assertSame(25, UserRole::VERIFIED_RESEARCHER->weight());
        $this->assertSame(20, UserRole::RESEARCHER->weight());
        $this->assertSame(15, UserRole::SUBSCRIBER->weight());
        $this->assertSame(0, UserRole::GUEST->weight());

        // 2. فحص التدرج الهرمي (isAtLeast)
        $this->assertTrue(UserRole::SUPER_ADMIN->isAtLeast(UserRole::EDITOR));
        $this->assertTrue(UserRole::CHIEF_EDITOR->isAtLeast(UserRole::CATALOGER));
        $this->assertFalse(UserRole::GUEST->isAtLeast(UserRole::RESEARCHER));
        $this->assertFalse(UserRole::RESEARCHER->isAtLeast(UserRole::VERIFIED_RESEARCHER));

        // 3. فحص أهلية دخول الاستوديو (canAccessStudio)
        $studioRoles = [UserRole::SUPER_ADMIN, UserRole::CHIEF_EDITOR, UserRole::EDITOR, UserRole::TRANSCRIBER];
        foreach (UserRole::cases() as $role) {
            if (in_array($role, $studioRoles, true)) {
                $this->assertTrue($role->canAccessStudio(), "الدور {$role->value} يجب أن يتمكن من دخول الاستوديو");
            } else {
                $this->assertFalse($role->canAccessStudio(), "الدور {$role->value} يجب ألا يتمكن من دخول الاستوديو");
            }
        }

        // 4. فحص أهلية الفهرسة وتعديل البيانات الوصفية (canCurateMetadata)
        $curateRoles = [UserRole::SUPER_ADMIN, UserRole::CHIEF_EDITOR, UserRole::EDITOR, UserRole::CATALOGER];
        foreach (UserRole::cases() as $role) {
            if (in_array($role, $curateRoles, true)) {
                $this->assertTrue($role->canCurateMetadata(), "الدور {$role->value} يجب أن يتمكن من فهرسة البيانات الوصفية");
            } else {
                $this->assertFalse($role->canCurateMetadata(), "الدور {$role->value} يجب ألا يتمكن من فهرسة البيانات الوصفية");
            }
        }

        // 5. فحص أهلية النشر العام (canPublish)
        $publishRoles = [UserRole::SUPER_ADMIN, UserRole::CHIEF_EDITOR];
        foreach (UserRole::cases() as $role) {
            if (in_array($role, $publishRoles, true)) {
                $this->assertTrue($role->canPublish(), "الدور {$role->value} يجب أن يمتلك صلاحية النشر");
            } else {
                $this->assertFalse($role->canPublish(), "الدور {$role->value} يجب ألا يمتلك صلاحية النشر");
            }
        }
    }

    #[Test]
    public function it_enforces_mass_assignment_guardrail(): void
    {
        $user = new User();

        // الحصانة 3: استبعاد role و is_active من $fillable
        $this->assertNotContains(
            'role',
            $user->getFillable(),
            'درع الحصانة 3: حقل role يجب ألا يكون قابلاً للتعيين الكتلي في fillable'
        );
        $this->assertNotContains(
            'is_active',
            $user->getFillable(),
            'درع الحصانة 3: حقل is_active يجب ألا يكون قابلاً للتعيين الكتلي في fillable'
        );
    }

    #[Test]
    public function it_casts_role_and_is_active_correctly(): void
    {
        $user = new User();
        $user->role = 'chief_editor';
        $user->is_active = 1;

        $this->assertInstanceOf(
            UserRole::class,
            $user->role,
            'يجب تحويل حقل role تلقائياً إلى Enum من نوع UserRole'
        );
        $this->assertSame(UserRole::CHIEF_EDITOR, $user->role);
        $this->assertIsBool($user->is_active);
        $this->assertTrue($user->is_active);
    }

    #[Test]
    public function it_provides_helper_methods_on_user_model(): void
    {
        $admin = new User();
        $admin->role = UserRole::SUPER_ADMIN;

        $editor = new User();
        $editor->role = UserRole::EDITOR;

        $guest = new User();
        $guest->role = UserRole::GUEST;

        // 1. isSuperAdmin
        $this->assertTrue($admin->isSuperAdmin());
        $this->assertFalse($editor->isSuperAdmin());

        // 2. hasRole
        $this->assertTrue($editor->hasRole(UserRole::EDITOR));
        $this->assertTrue($editor->hasRole('editor'));
        $this->assertTrue($editor->hasRole('cataloger', 'editor', 'transcriber'));
        $this->assertFalse($editor->hasRole('chief_editor'));

        // 3. isAtLeast
        $this->assertTrue($editor->isAtLeast(UserRole::RESEARCHER));
        $this->assertFalse($guest->isAtLeast(UserRole::RESEARCHER));

        // 4. canAccessStudio
        $this->assertTrue($editor->canAccessStudio());
        $this->assertFalse($guest->canAccessStudio());
    }
}

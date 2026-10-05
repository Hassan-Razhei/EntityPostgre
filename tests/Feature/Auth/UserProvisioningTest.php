<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص استنبات حسابات الأدوار الـ 12 وأمر الطرفية لإنشاء المدير العام
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md
 */
class UserProvisioningTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_seeds_default_users_for_all_twelve_roles(): void
    {
        $this->seed(UserSeeder::class);

        // التحقق من إنشاء 12 مستخدماً بالضبط
        $this->assertDatabaseCount('users', 12);

        // التحقق من وجود حساب نشط لكل دور من الأدوار الـ 12
        foreach (UserRole::cases() as $role) {
            $user = User::where('role', $role->value)->first();

            $this->assertNotNull($user, "يجب أن يتم استنبات مستخدم للدور: {$role->value}");
            $this->assertSame($role, $user->role);
            $this->assertTrue($user->is_active, "الحساب المستنبت للدور {$role->value} يجب أن يكون نشطاً");
            $this->assertNotEmpty($user->email);
        }
    }

    #[Test]
    public function it_creates_super_admin_via_artisan_command(): void
    {
        $this->artisan('user:create-admin')
            ->expectsQuestion('أدخل اسم المدير العام', 'المدير الجذري للنظام')
            ->expectsQuestion('أدخل البريد الإلكتروني', 'root@archive.org')
            ->expectsQuestion('أدخل كلمة المرور', 'SuperSecretPass123!')
            ->expectsQuestion('تأكيد كلمة المرور', 'SuperSecretPass123!')
            ->expectsOutputToContain('تم إنشاء حساب المدير العام بنجاح')
            ->assertSuccessful();

        $admin = User::where('email', 'root@archive.org')->first();

        $this->assertNotNull($admin, 'يجب العثور على حساب المدير العام في قاعدة البيانات');
        $this->assertSame(UserRole::SUPER_ADMIN, $admin->role);
        $this->assertTrue($admin->is_active);
        $this->assertTrue($admin->isSuperAdmin());
    }

    #[Test]
    public function it_rejects_duplicate_email_in_create_admin_command(): void
    {
        User::factory()->create([
            'email' => 'existing@archive.org',
        ]);

        $this->artisan('user:create-admin')
            ->expectsQuestion('أدخل اسم المدير العام', 'مدير جديد')
            ->expectsQuestion('أدخل البريد الإلكتروني', 'existing@archive.org')
            ->expectsOutputToContain('مسجل مسبقاً')
            ->assertFailed();
    }

    #[Test]
    public function it_rejects_password_mismatch_in_create_admin_command(): void
    {
        $this->artisan('user:create-admin')
            ->expectsQuestion('أدخل اسم المدير العام', 'مدير عام')
            ->expectsQuestion('أدخل البريد الإلكتروني', 'mismatch@archive.org')
            ->expectsQuestion('أدخل كلمة المرور', 'Password123!')
            ->expectsQuestion('تأكيد كلمة المرور', 'DifferentPassword456!')
            ->expectsOutputToContain('غير متطابقة')
            ->assertFailed();

        $this->assertDatabaseMissing('users', [
            'email' => 'mismatch@archive.org',
        ]);
    }
}

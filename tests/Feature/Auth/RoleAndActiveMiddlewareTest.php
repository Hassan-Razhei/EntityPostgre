<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص حواجز المسارات والميدلوير للرتب والنشاط
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md
 */
class RoleAndActiveMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // تسجيل مسارات تجريبية معزولة لاختبار الحواجز
        Route::middleware(['web', 'auth', 'active'])->get('/test-active-route', function () {
            return response()->json(['message' => 'active_ok']);
        });

        Route::middleware(['web', 'auth', 'active', 'role:editor'])->get('/test-role-single', function () {
            return response()->json(['message' => 'role_editor_ok']);
        });

        Route::middleware(['web', 'auth', 'active', 'role:editor,chief_editor,super_admin'])->get('/test-role-multiple', function () {
            return response()->json(['message' => 'role_multiple_ok']);
        });
    }

    #[Test]
    public function it_allows_active_authenticated_users(): void
    {
        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/test-active-route');

        $response->assertOk();
        $response->assertJson(['message' => 'active_ok']);
    }

    #[Test]
    public function it_blocks_inactive_users_and_invalidates_session(): void
    {
        $user = User::factory()->create([
            'is_active' => false,
        ]);

        $response = $this->actingAs($user)->get('/test-active-route');

        $response->assertStatus(403);
        $this->assertGuest(); // التحقق من مصادرة الجلسة وطرد الحساب المجمد
    }

    #[Test]
    public function it_allows_user_with_exact_required_role(): void
    {
        $editor = User::factory()->withRole(UserRole::EDITOR)->create();

        $response = $this->actingAs($editor)->get('/test-role-single');

        $response->assertOk();
        $response->assertJson(['message' => 'role_editor_ok']);
    }

    #[Test]
    public function it_denies_user_without_required_role_with_informative_403(): void
    {
        $researcher = User::factory()->withRole(UserRole::RESEARCHER)->create();

        $response = $this->actingAs($researcher)->get('/test-role-single');

        $response->assertStatus(403);
    }

    #[Test]
    public function it_allows_any_matching_role_in_multiple_role_middleware(): void
    {
        $editor = User::factory()->withRole(UserRole::EDITOR)->create();
        $chief = User::factory()->withRole(UserRole::CHIEF_EDITOR)->create();
        $admin = User::factory()->withRole(UserRole::SUPER_ADMIN)->create();
        $transcriber = User::factory()->withRole(UserRole::TRANSCRIBER)->create();

        $this->actingAs($editor)->get('/test-role-multiple')->assertOk();
        $this->actingAs($chief)->get('/test-role-multiple')->assertOk();
        $this->actingAs($admin)->get('/test-role-multiple')->assertOk();

        // دور غير مصرح له
        $this->actingAs($transcriber)->get('/test-role-multiple')->assertStatus(403);
    }

    #[Test]
    public function it_redirects_unauthenticated_guests_to_login(): void
    {
        $response = $this->get('/test-role-single');

        $response->assertRedirect('/login');
    }
}

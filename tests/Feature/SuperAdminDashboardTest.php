<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص بوابة قمرة قيادة السوبر أدمن (Proof of Concept)
 * المسار: /superadmin/dashboard
 * المكون: AdminDashboard
 */
class SuperAdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;
    private User $editor;
    private User $viewer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();

        $this->superAdmin = User::factory()->superAdmin()->create();
        $this->editor = User::factory()->editor()->create();
        $this->viewer = User::factory()->create();
    }

    #[Test]
    public function it_redirects_unauthenticated_guests_to_login(): void
    {
        $response = $this->get('/superadmin/dashboard');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function it_forbids_non_super_admin_users_from_accessing_dashboard(): void
    {
        // المحرر يُمنع بـ 403
        $this->actingAs($this->editor)
            ->get('/superadmin/dashboard')
            ->assertStatus(403);

        // المستخدم العادي يُمنع بـ 403
        $this->actingAs($this->viewer)
            ->get('/superadmin/dashboard')
            ->assertStatus(403);
    }

    #[Test]
    public function it_allows_super_admin_to_access_and_renders_admin_dashboard_component(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard')
            );
    }
}

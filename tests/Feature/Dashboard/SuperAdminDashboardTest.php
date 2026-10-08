<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Author;
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

    #[Test]
    public function it_shares_live_database_statistics_and_recent_activities_to_admin_dashboard(): void
    {
        // تجهيز بيانات اختبارية حقيقية
        Book::factory()->count(5)->create();
        Manuscript::factory()->count(3)->create();
        Audio::factory()->count(4)->create();
        Video::factory()->count(2)->create();
        Author::factory()->count(6)->create();

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard')
                ->has('stats', fn (Assert $stats) => $stats
                    ->where('books', 5)
                    ->where('manuscripts', 3)
                    ->where('audios', 4)
                    ->where('videos', 2)
                    ->where('authors', 6)
                    ->etc()
                )
                ->has('recentActivities')
            );
    }

    #[Test]
    public function it_shares_recent_users_and_accurate_deletions_count_to_admin_dashboard(): void
    {
        // تجهيز أصول محذوفة ناعماً (Soft Deleted)
        $b1 = Book::factory()->create();
        $b2 = Book::factory()->create();
        $b1->delete();
        $b2->delete();

        $a1 = Author::factory()->create();
        $a1->delete();

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard')
                ->where('stats.deletions', 3)
                ->has('recentUsers', 3) // المستخدمون الثلاثة المنشأون في setUp
            );
    }
}

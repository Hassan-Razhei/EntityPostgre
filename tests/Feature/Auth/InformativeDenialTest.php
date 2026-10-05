<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص الردع التفسيري وشاشة الحظر 403
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الخامس: تغذية)
 */
class InformativeDenialTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_renders_informative_403_page_when_role_denied_on_web_routes(): void
    {
        $researcher = User::factory()->researcher()->create();

        // محاولة دخول الاستوديو من باحث عادي يجب أن ترجع صفحة 403 التفسيرية في Inertia
        $response = $this->actingAs($researcher)->get('/studio/resume');

        $response->assertStatus(403);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Errors/403')
            ->has('message')
            ->where('status', 403)
        );
    }

    #[Test]
    public function it_renders_informative_403_page_when_inactive_user_accesses_web(): void
    {
        $inactiveUser = User::factory()->superAdmin()->inactive()->create();

        $response = $this->actingAs($inactiveUser)->get('/dashboard');

        $response->assertStatus(403);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Errors/403')
            ->where('status', 403)
            ->where('message', 'تم تجميد هذا الحساب من قبل إدارة المنظومة. يرجى مراجعة إدارة الأرشيف.')
        );
    }

    #[Test]
    public function it_maintains_json_responses_for_api_requests_with_informative_denial(): void
    {
        $researcher = User::factory()->researcher()->create();

        // طلب API مرفوض يرجع JSON مع نص الردع العربي وليس HTML
        $response = $this->actingAs($researcher)
            ->postJson(route('api.system.run-command'), ['command' => 'storage:sync']);

        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
        $this->assertStringContainsString('رتبتك الحالية هي', $response->json('message'));
    }
}

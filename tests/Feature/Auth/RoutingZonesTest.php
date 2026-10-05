<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص حراسة وترسيم الأحياز الجغرافية للمسارات
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الرابع: مناطق)
 */
class RoutingZonesTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;
    private User $chiefEditor;
    private User $editor;
    private User $transcriber;
    private User $researcher;
    private User $inactiveUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->superAdmin()->create();
        $this->chiefEditor = User::factory()->chiefEditor()->create();
        $this->editor = User::factory()->editor()->create();
        $this->transcriber = User::factory()->transcriber()->create();
        $this->researcher = User::factory()->researcher()->create();
        $this->inactiveUser = User::factory()->superAdmin()->inactive()->create();
    }

    #[Test]
    public function it_restricts_studio_routes_to_studio_staff_only(): void
    {
        // الباحث العادي يُحظر من دخول الاستوديو بـ 403
        $this->actingAs($this->researcher)
            ->get('/studio/resume')
            ->assertStatus(403);

        // طاقم الاستوديو والمدير العام مصرح لهم بالدخول (لا يستقبلون 403)
        $this->actingAs($this->transcriber)->get('/studio/resume')->assertStatus(302);
        $this->actingAs($this->editor)->get('/studio/resume')->assertStatus(302);
        $this->actingAs($this->chiefEditor)->get('/studio/resume')->assertStatus(302);
        $this->actingAs($this->superAdmin)->get('/studio/resume')->assertStatus(302);
    }

    #[Test]
    public function it_restricts_system_commands_strictly_to_super_admin(): void
    {
        // المحرر ورئيس التحرير والباحث يُحظرون من لوحة أوامر النظام بـ 403
        $this->actingAs($this->editor)
            ->get('/system/commands')
            ->assertStatus(403);

        $this->actingAs($this->chiefEditor)
            ->get('/system/commands')
            ->assertStatus(403);

        $this->actingAs($this->researcher)
            ->get('/system/commands')
            ->assertStatus(403);

        // المدير العام فقط يعبر بنجاح
        $this->actingAs($this->superAdmin)
            ->get('/system/commands')
            ->assertOk();
    }

    #[Test]
    public function it_blocks_inactive_users_across_zones(): void
    {
        // المستخدم المجمد يُطرد حتى لو كان مديراً عاماً
        $this->actingAs($this->inactiveUser)
            ->get('/dashboard')
            ->assertStatus(403);
    }
}

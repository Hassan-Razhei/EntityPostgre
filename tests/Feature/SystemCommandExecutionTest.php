<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SystemCommandExecutionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_allows_super_admin_to_run_whitelisted_artisan_command(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin)
            ->postJson(route('api.system.run-command'), [
                'command' => 'optimize:clear',
            ]);

        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
        ]);
        $this->assertNotEmpty($response->json('output'));
    }

    #[Test]
    public function it_allows_super_admin_to_run_custom_console_commands(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        // Testing custom command from app/Console/Commands: content:regenerate-slugs
        $response = $this->actingAs($superAdmin)
            ->postJson(route('api.system.run-command'), [
                'command' => 'content:regenerate-slugs',
            ]);

        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
        ]);
    }

    #[Test]
    public function it_normalizes_php_artisan_prefix_in_command_string(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        // Testing command prefixed with "php artisan "
        $response = $this->actingAs($superAdmin)
            ->postJson(route('api.system.run-command'), [
                'command' => 'php artisan cache:clear',
            ]);

        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
        ]);
    }

    #[Test]
    public function it_allows_super_admin_to_run_seed_realistic_command(): void
    {
        $superAdmin = User::factory()->superAdmin()->create([
            'email' => 'super_admin@archive.org',
        ]);

        $response = $this->actingAs($superAdmin)
            ->postJson(route('api.system.run-command'), [
                'command' => 'project:seed-realistic',
                'args' => ['--count' => 1],
            ]);

        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
        ]);
    }

    #[Test]
    public function it_rejects_unwhitelisted_commands_with_403(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin)
            ->postJson(route('api.system.run-command'), [
                'command' => 'migrate:fresh',
            ]);

        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Command not allowed',
        ]);
    }
}

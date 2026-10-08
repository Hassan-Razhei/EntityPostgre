<?php

namespace Tests\Feature\Entities\Taxonomies;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoryAndTagControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->superAdmin()->create();
        $this->actingAs($this->user);
    }

    // ==========================================
    // CATEGORY TESTS
    // ==========================================

    #[Test]
    public function category_index_page_loads_successfully()
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Categories/Index')
            ->has('categories')
        );
    }

    #[Test]
    public function can_create_category()
    {
        $data = [
            'name' => 'New Category',
            'description' => 'Test Description',
            'parent_id' => null,
        ];

        $response = $this->post(route('categories.store'), $data);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    #[Test]
    public function can_update_category()
    {
        $category = Category::factory()->create();
        $data = [
            'name' => 'Updated Category',
            'description' => 'Updated Description',
        ];

        $response = $this->put(route('categories.update', $category), $data);

        $response->assertRedirect(route('categories.show', $category));
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    #[Test]
    public function can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    // ==========================================
    // TAG TESTS
    // ==========================================

    #[Test]
    public function tag_index_page_loads_successfully()
    {
        $response = $this->get(route('tags.index'));
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Tags/Index')
            ->has('tags')
        );
    }

    #[Test]
    public function can_create_tag()
    {
        $data = [
            'name' => 'New Tag',
            'type' => 'general',
        ];

        $response = $this->post(route('tags.store'), $data);

        $response->assertRedirect(route('tags.index'));
        $this->assertDatabaseHas('tags', ['name' => 'New Tag']);
    }

    #[Test]
    public function can_update_tag()
    {
        $tag = Tag::factory()->create();
        $data = [
            'name' => 'Updated Tag',
            'type' => 'specific',
        ];

        $response = $this->put(route('tags.update', $tag), $data);

        $response->assertRedirect(route('tags.show', $tag));
        $this->assertDatabaseHas('tags', ['name' => 'Updated Tag']);
    }

    #[Test]
    public function can_delete_tag()
    {
        $tag = Tag::factory()->create();

        $response = $this->delete(route('tags.destroy', $tag));

        $response->assertRedirect(route('tags.index'));
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}

<?php

namespace Tests\Feature\Entities\Taxonomies;

use App\Models\Book;
use App\Models\Collection;
use App\Models\Manuscript;
use App\Models\Series;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaxonomyAttachmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'super_admin']);
    }

    #[Test]
    public function it_attaches_a_book_to_a_collection_via_endpoint(): void
    {
        $collection = Collection::factory()->create(['name' => 'المختارات النبوية']);
        $book = Book::factory()->create(['title' => 'جامع العلوم والحكم']);

        $response = $this->actingAs($this->user)
            ->postJson("/collections/{$collection->id}/entities", [
                'entity_type' => 'book',
                'entity_id' => $book->id,
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'collection_id' => $collection->id,
                'entity_id' => $book->id,
            ]);

        $this->assertDatabaseHas('collectables', [
            'collection_id' => $collection->id,
            'entity_id' => $book->id,
            'entity_type' => 'book',
        ]);
    }

    #[Test]
    public function it_attaches_a_manuscript_to_a_series_via_endpoint(): void
    {
        $series = Series::factory()->create(['title' => 'سلسلة المخطوطات التراثية']);
        $manuscript = Manuscript::factory()->create(['title' => 'مخطوطة السير']);

        $response = $this->actingAs($this->user)
            ->postJson("/series/{$series->id}/entities", [
                'entity_type' => 'manuscript',
                'entity_id' => $manuscript->id,
                'position' => 1,
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'series_id' => $series->id,
                'entity_id' => $manuscript->id,
            ]);

        $this->assertDatabaseHas('seriables', [
            'series_id' => $series->id,
            'entity_id' => $manuscript->id,
            'entity_type' => 'manuscript',
        ]);
    }
}

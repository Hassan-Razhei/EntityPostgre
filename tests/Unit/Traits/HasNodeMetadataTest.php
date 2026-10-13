<?php

namespace Tests\Unit\Traits;

use App\Models\Book;
use App\Models\ContentNode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HasNodeMetadataTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_handles_audio_video_time_and_duration_metadata(): void
    {
        $book = Book::factory()->create();
        $node = new ContentNode([
            'entity_type' => 'book',
            'entity_id' => $book->id,
            'title' => 'Time Test Node',
            'start_time' => 12.5,
            'end_time' => 45.8,
            'duration' => 33.3,
        ]);

        $this->assertEquals(12.5, $node->start_time);
        $this->assertEquals(45.8, $node->end_time);
        $this->assertEquals(33.3, $node->duration);

        $this->assertEquals(12.5, $node->metadata['start_time']);
        $this->assertEquals(45.8, $node->metadata['end_time']);
        $this->assertEquals(33.3, $node->metadata['duration']);
    }

    #[Test]
    public function it_handles_manuscript_folio_and_image_metadata(): void
    {
        $node = new ContentNode([
            'title' => 'Manuscript Folio Node',
            'folio_number' => '12b',
            'image_url' => 'https://archive.org/images/folio12b.jpg',
        ]);

        $this->assertEquals('12b', $node->folio_number);
        $this->assertEquals('https://archive.org/images/folio12b.jpg', $node->image_url);

        $this->assertEquals('12b', $node->metadata['folio_number']);
        $this->assertEquals('https://archive.org/images/folio12b.jpg', $node->metadata['image_url']);
    }

    #[Test]
    public function it_handles_editing_and_transcription_metadata(): void
    {
        $node = new ContentNode([
            'title' => 'Editor Node',
            'page_number' => 245,
            'description' => 'Important chapter notes',
            'resource_url' => 'https://external.resource/file.pdf',
            'transcription_status' => 'completed',
            'is_manually_edited' => true,
            'last_editor_id' => 'editor-uuid-789',
        ]);

        $this->assertEquals(245, $node->page_number);
        $this->assertEquals('Important chapter notes', $node->description);
        $this->assertEquals('https://external.resource/file.pdf', $node->resource_url);
        $this->assertEquals('completed', $node->transcription_status);
        $this->assertTrue($node->is_manually_edited);
        $this->assertEquals('editor-uuid-789', $node->last_editor_id);

        $this->assertEquals(245, $node->metadata['page_number']);
        $this->assertEquals('completed', $node->metadata['transcription_status']);
    }

    #[Test]
    public function it_provides_smart_helper_methods_for_metadata(): void
    {
        $node = new ContentNode(['title' => 'Helper Test']);

        $this->assertFalse($node->hasMetadata('custom_key'));
        $this->assertEquals('fallback', $node->getMetadata('custom_key', 'fallback'));

        $node->setMetadata('custom_key', 'custom_value');
        $this->assertTrue($node->hasMetadata('custom_key'));
        $this->assertEquals('custom_value', $node->getMetadata('custom_key'));

        $node->forgetMetadata('custom_key');
        $this->assertFalse($node->hasMetadata('custom_key'));
        $this->assertNull($node->getMetadata('custom_key'));
    }

    #[Test]
    public function it_persists_metadata_properly_in_postgresql_database(): void
    {
        $book = Book::factory()->create();
        $node = ContentNode::create([
            'entity_type' => 'book',
            'entity_id' => $book->id,
            'title' => 'Persisted Node',
            'start_time' => 5.0,
            'end_time' => 25.0,
            'folio_number' => '1a',
            'page_number' => 10,
            'is_manually_edited' => true,
        ]);

        $freshNode = ContentNode::find($node->id);

        $this->assertNotNull($freshNode);
        $this->assertEquals(5.0, $freshNode->start_time);
        $this->assertEquals(25.0, $freshNode->end_time);
        $this->assertEquals('1a', $freshNode->folio_number);
        $this->assertEquals(10, $freshNode->page_number);
        $this->assertTrue($freshNode->is_manually_edited);
        $this->assertIsArray($freshNode->metadata);
    }
}

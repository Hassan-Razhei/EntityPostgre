<?php

namespace Tests\Unit\Services;

use App\Enums\ContentStatus;
use App\Models\Audio;
use App\Models\Author;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\Video;
use App\Services\DashboardStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardStatsServiceTest extends TestCase
{
    use RefreshDatabase;

    private DashboardStatsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DashboardStatsService();
    }

    #[Test]
    public function it_returns_all_expected_statistics_keys(): void
    {
        $stats = $this->service->getStats();

        // 1. إجماليات الكيانات الـ 16
        $expectedEntities = [
            'books', 'manuscripts', 'audios', 'videos', 'authors',
            'publishers', 'categories', 'tags', 'users', 'collections',
            'series', 'topics', 'comments', 'activities', 'versions', 'deletions',
        ];
        foreach ($expectedEntities as $key) {
            $this->assertArrayHasKey($key, $stats);
        }

        // 2. إحصائيات قمع الاستوديو
        $expectedFunnel = [
            'studio_books', 'studio_manuscripts', 'studio_audios', 'studio_videos',
            'funnel_drafts', 'funnel_reviewed', 'funnel_scholarly', 'funnel_published',
        ];
        foreach ($expectedFunnel as $key) {
            $this->assertArrayHasKey($key, $stats);
        }

        // 3. مفاتيح ContentStatus لكل أصل
        foreach (['books' => 'book', 'manuscripts' => 'manuscript', 'audios' => 'audio', 'videos' => 'video'] as $assetKey => $type) {
            foreach (ContentStatus::forAsset($type) as $status) {
                $this->assertArrayHasKey("{$assetKey}_{$status->value}", $stats);
            }
        }
    }

    #[Test]
    public function it_calculates_status_counts_accurately(): void
    {
        Book::factory()->create(['status' => 'draft']);
        Book::factory()->create(['status' => 'draft']);
        Book::factory()->create(['status' => 'published']);

        $counts = $this->service->statusCounts(Book::class, 'books');

        $this->assertEquals(2, $counts['books_draft']);
        $this->assertEquals(1, $counts['books_published']);
        $this->assertEquals(0, $counts['books_curriculum']);
    }

    #[Test]
    public function it_aggregates_soft_deleted_entities_accurately(): void
    {
        $book = Book::factory()->create(['title' => 'Trashed Book']);
        $manuscript = Manuscript::factory()->create(['title' => 'Trashed MS']);
        $audio = Audio::factory()->create(['title' => 'Trashed Audio']);
        $video = Video::factory()->create(['title' => 'Trashed Video']);
        $author = Author::factory()->create(['name' => 'Trashed Author']);

        $book->delete();
        $manuscript->delete();
        $audio->delete();
        $video->delete();
        $author->delete();

        $deletions = $this->service->getSoftDeletions();

        $this->assertCount(5, $deletions);

        $titles = $deletions->pluck('title')->all();
        $this->assertContains('Trashed Book', $titles);
        $this->assertContains('Trashed MS', $titles);
        $this->assertContains('Trashed Audio', $titles);
        $this->assertContains('Trashed Video', $titles);
        $this->assertContains('Trashed Author', $titles);

        // التحقق من وجود مسارات الاستعادة
        foreach ($deletions as $item) {
            $this->assertArrayHasKey('restore_url', $item);
            $this->assertArrayHasKey('type_label', $item);
            $this->assertArrayHasKey('type_chip', $item);
        }
    }
}

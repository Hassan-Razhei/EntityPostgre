<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\Audio;
use App\Models\Video;
use App\Models\ContentNode;
use App\Enums\ContentNodeType;

class SeedRealisticData extends Seeder
{
    /**
     * Run the database seeds.
     * Step 8: Final Verification Data
     */
    public function run(): void
    {
        // 1. Create a Test User
        $user = User::firstOrCreate(
            ['email' => 'admin@entity.test'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );

        // 2. Book Hierarchy (The Standard)
        $book = Book::create([
            'title' => 'The Book of Knowledge',
            'slug' => 'book-of-knowledge',
            'type' => 'book'
        ]);

        $this->createBookHierarchy($book);

        // 3. Manuscript Hierarchy (The Super-Hybrid)
        $manuscript = Manuscript::create([
            'title' => 'Ancient Manuscript',
            'slug' => 'ancient-manuscript',
            'type' => 'manuscript'
        ]);

        $this->createManuscriptHierarchy($manuscript);

        // 4. Audio (Time-Based)
        $audio = Audio::create([
            'title' => 'Lecture Series',
            'slug' => 'lecture-series',
            'type' => 'audio',
            'file_path' => 'audio/sample.mp3'
        ]);

        $this->createAudioSegments($audio);

        // 5. Video (Time-Based)
        $video = Video::create([
            'title' => 'Cinema Masterpiece',
            'slug' => 'cinema-masterpiece',
            'type' => 'video',
            'file_path' => 'video/sample.mp4'
        ]);

        $this->createVideoSegments($video);
    }

    private function createBookHierarchy($book)
    {
        $levels = [
            ['type' => 'sub_book', 'title' => 'Volume 1'],
            ['type' => 'part', 'title' => 'Part 1'],
            ['type' => 'bab', 'title' => 'Chapter 1 (Bab)'],
            ['type' => 'chapter', 'title' => 'Section 1 (Fasl)'],
            ['type' => 'masalah', 'title' => 'Issue 1'],
            ['type' => 'section', 'title' => 'Point 1'],
        ];

        foreach ($levels as $index => $level) {
            $book->nodes()->create([
                'title' => $level['title'],
                'slug' => \Str::slug($level['title']),
                'type' => $level['type'],
                'order' => $index + 1,
                'content_html' => "<p>Content for {$level['title']}</p>",
                'plain_text' => "Content for {$level['title']}",
            ]);
        }
    }

    private function createManuscriptHierarchy($manuscript)
    {
        // Hybrid Structure
        $manuscript->nodes()->create([
            'title' => 'Introduction',
            'slug' => 'intro',
            'type' => 'part',
            'order' => 1,
            'content_html' => '<p>Introductory text.</p>',
            'plain_text' => 'Introductory text.',
        ]);

        // Markers (Folios/Pages)
        for ($i = 1; $i <= 3; $i++) {
            $manuscript->nodes()->create([
                'title' => "Folio {$i}a",
                'slug' => "folio-{$i}a",
                'type' => 'folio',
                'order' => $i + 1,
                'content_html' => "<h4 class=\"structure-marker\" data-type=\"folio\" data-folio=\"{$i}\">Folio {$i}a:</h4><p>Text on folio {$i}a...</p>",
                'plain_text' => "Folio {$i}a: Text on folio {$i}a...",
            ]);
        }
    }

    private function createAudioSegments($audio)
    {
        $audio->nodes()->create([
            'title' => 'Opening Theme',
            'slug' => 'opening',
            'type' => 'track',
            'start_time' => 0,
            'end_time' => 60,
            'order' => 1,
            'content_html' => '<h4 class="structure-marker" data-type="track" data-start-time="0">Opening Theme:</h4>',
        ]);

        $audio->nodes()->create([
            'title' => 'Main Topic',
            'slug' => 'main-topic',
            'type' => 'segment',
            'start_time' => 60,
            'end_time' => 1200,
            'order' => 2,
            'content_html' => '<h4 class="structure-marker" data-type="segment" data-start-time="60">Main Topic:</h4>',
        ]);
    }

    private function createVideoSegments($video)
    {
        $video->nodes()->create([
            'title' => 'Scene 1: The Beginning',
            'slug' => 'scene-1',
            'type' => 'scene',
            'start_time' => 0,
            'end_time' => 300,
            'order' => 1,
            'content_html' => '<h4 class="structure-marker" data-type="scene" data-start-time="0">Scene 1:</h4>',
        ]);
    }
}

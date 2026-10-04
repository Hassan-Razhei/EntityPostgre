<?php

namespace Tests\Feature\Storage;

use App\Models\Audio;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaStorageAndUploadTest extends TestCase
{
    protected array $createdFiles = [];

    protected function tearDown(): void
    {
        // Clean up any test files created on the media disk
        foreach ($this->createdFiles as $filePath) {
            if ($filePath && Storage::disk('media')->exists($filePath)) {
                Storage::disk('media')->delete($filePath);
            }
        }

        parent::tearDown();
    }

    /**
     * Test 1: Verify the media disk is properly configured and functional
     */
    public function test_media_disk_configuration_and_basic_operations()
    {
        $this->assertNotNull(config('filesystems.disks.media'), 'The media disk must be configured in filesystems.php');
        $this->assertEquals('local', config('filesystems.disks.media.driver'));

        $testPath = 'tests/unit_test_' . uniqid() . '.txt';
        $content = 'Testing Media Disk I/O';

        // Write
        $written = Storage::disk('media')->put($testPath, $content);
        $this->assertTrue($written);
        $this->createdFiles[] = $testPath;

        // Read & Exists
        $this->assertTrue(Storage::disk('media')->exists($testPath));
        $this->assertEquals($content, Storage::disk('media')->get($testPath));

        // URL format
        $url = Storage::disk('media')->url($testPath);
        $this->assertStringContainsString('/media/' . $testPath, $url);

        // Delete
        $deleted = Storage::disk('media')->delete($testPath);
        $this->assertTrue($deleted);
        $this->assertFalse(Storage::disk('media')->exists($testPath));
    }

    /**
     * Test 2: Upload a book and verify files are stored on media disk with clean relative paths
     */
    public function test_book_upload_stores_files_in_media_disk_with_relative_paths()
    {
        $user = User::factory()->create();

        $fakePdf = UploadedFile::fake()->create('sample_book_' . uniqid() . '.pdf', 50, 'application/pdf');
        $fakeCover = UploadedFile::fake()->image('book_cover_' . uniqid() . '.jpg', 200, 300);

        $response = $this->actingAs($user)->post(route('books.store'), [
            'title' => 'Test Storage Book ' . uniqid(),
            'description' => 'Test book uploaded to media disk',
            'file' => $fakePdf,
            'cover' => $fakeCover,
        ]);

        $response->assertRedirect(route('books.index'));

        $book = Book::where('title', 'LIKE', 'Test Storage Book%')->latest()->first();
        $this->assertNotNull($book);

        // Verify clean relative paths in database
        $this->assertStringStartsWith('books/', $book->file_path);
        $this->assertStringStartsWith('covers/', $book->cover_path);

        // Track for cleanup
        $this->createdFiles[] = $book->file_path;
        $this->createdFiles[] = $book->cover_path;

        // Verify URL accessors
        $this->assertNotNull($book->cover_url);
        $this->assertStringContainsString('/media/' . $book->cover_path, $book->cover_url);
        $this->assertNotNull($book->file_url);
        $this->assertStringContainsString('/media/' . $book->file_path, $book->file_url);

        // Verify physical existence on the media disk
        $this->assertTrue(
            Storage::disk('media')->exists($book->file_path),
            "Book PDF must physically exist on media disk at: {$book->file_path}"
        );
        $this->assertTrue(
            Storage::disk('media')->exists($book->cover_path),
            "Book Cover must physically exist on media disk at: {$book->cover_path}"
        );
    }

    /**
     * Test 3: Upload a manuscript and verify cover is stored on media disk with relative path
     */
    public function test_manuscript_upload_stores_cover_in_media_disk_with_relative_path()
    {
        $user = User::factory()->create();

        $fakeCover = UploadedFile::fake()->image('ms_cover_' . uniqid() . '.jpg', 300, 400);

        $response = $this->actingAs($user)->post(route('manuscripts.store'), [
            'title' => 'Test Storage Manuscript ' . uniqid(),
            'code' => 'MS_STORAGE_' . uniqid(),
            'description' => 'Test manuscript uploaded to media disk',
            'cover' => $fakeCover,
        ]);

        $response->assertRedirect(route('manuscripts.index'));

        $manuscript = Manuscript::where('title', 'LIKE', 'Test Storage Manuscript%')->latest()->first();
        $this->assertNotNull($manuscript);

        $this->assertStringStartsWith('covers/', $manuscript->cover_path);
        $this->createdFiles[] = $manuscript->cover_path;

        $this->assertTrue(
            Storage::disk('media')->exists($manuscript->cover_path),
            "Manuscript cover must exist on media disk at: {$manuscript->cover_path}"
        );
    }

    /**
     * Test 4: Upload audio and verify storage on media disk
     */
    public function test_audio_upload_stores_file_in_media_disk()
    {
        $user = User::factory()->create();

        $fakeAudio = UploadedFile::fake()->create('sample_audio_' . uniqid() . '.mp3', 100, 'audio/mpeg');
        $fakeCover = UploadedFile::fake()->image('audio_cover_' . uniqid() . '.jpg', 200, 200);

        $response = $this->actingAs($user)->post(route('audios.store'), [
            'title' => 'Test Storage Audio ' . uniqid(),
            'file' => $fakeAudio,
            'cover' => $fakeCover,
        ]);

        $response->assertRedirect(route('audios.index'));

        $audio = Audio::where('title', 'LIKE', 'Test Storage Audio%')->latest()->first();
        $this->assertNotNull($audio);

        $this->assertStringStartsWith('audio/', $audio->file_path);
        $this->assertStringStartsWith('covers/', $audio->cover_path);

        $this->createdFiles[] = $audio->file_path;
        $this->createdFiles[] = $audio->cover_path;

        $this->assertTrue(Storage::disk('media')->exists($audio->file_path));
        $this->assertTrue(Storage::disk('media')->exists($audio->cover_path));
    }

    /**
     * Test 5: Upload video and verify storage on media disk
     */
    public function test_video_upload_stores_file_in_media_disk()
    {
        $user = User::factory()->create();

        $fakeVideo = UploadedFile::fake()->create('sample_video_' . uniqid() . '.mp4', 200, 'video/mp4');
        $fakeCover = UploadedFile::fake()->image('video_cover_' . uniqid() . '.jpg', 200, 200);

        $response = $this->actingAs($user)->post(route('videos.store'), [
            'title' => 'Test Storage Video ' . uniqid(),
            'file' => $fakeVideo,
            'cover' => $fakeCover,
        ]);

        $response->assertRedirect(route('videos.index'));

        $video = Video::where('title', 'LIKE', 'Test Storage Video%')->latest()->first();
        $this->assertNotNull($video);

        $this->assertStringStartsWith('videos/', $video->file_path);
        $this->assertStringStartsWith('covers/', $video->cover_path);

        $this->createdFiles[] = $video->file_path;
        $this->createdFiles[] = $video->cover_path;

        $this->assertTrue(Storage::disk('media')->exists($video->file_path));
        $this->assertTrue(Storage::disk('media')->exists($video->cover_path));
    }

    /**
     * Test 6: Updating a book with a new PDF and cover stores the new files on media disk
     */
    public function test_book_update_replaces_files_on_media_disk()
    {
        $user = User::factory()->create();

        $initialPdf = UploadedFile::fake()->create('initial_' . uniqid() . '.pdf', 50, 'application/pdf');
        $initialCover = UploadedFile::fake()->image('initial_cover_' . uniqid() . '.jpg', 200, 300);

        $this->actingAs($user)->post(route('books.store'), [
            'title' => 'Update Test Book ' . uniqid(),
            'file' => $initialPdf,
            'cover' => $initialCover,
        ]);

        $book = Book::where('title', 'LIKE', 'Update Test Book%')->latest()->first();
        $this->assertNotNull($book);
        $oldFilePath = $book->file_path;
        $oldCoverPath = $book->cover_path;

        $this->createdFiles[] = $oldFilePath;
        $this->createdFiles[] = $oldCoverPath;

        $newPdf = UploadedFile::fake()->create('replaced_' . uniqid() . '.pdf', 60, 'application/pdf');
        $newCover = UploadedFile::fake()->image('replaced_cover_' . uniqid() . '.jpg', 250, 350);

        $response = $this->actingAs($user)->put(route('books.update', $book), [
            'title' => $book->title . ' (Updated)',
            'file' => $newPdf,
            'cover' => $newCover,
        ]);

        $book->refresh();
        $response->assertRedirect(route('books.show', $book));
        $this->assertNotEquals($oldFilePath, $book->file_path);
        $this->assertNotEquals($oldCoverPath, $book->cover_path);

        $this->createdFiles[] = $book->file_path;
        $this->createdFiles[] = $book->cover_path;

        $this->assertTrue(Storage::disk('media')->exists($book->file_path));
        $this->assertTrue(Storage::disk('media')->exists($book->cover_path));
    }

    /**
     * Test 8: Book Show page provides media URLs in Inertia props
     */
    public function test_book_show_page_renders_media_urls_in_inertia_props()
    {
        $user = User::factory()->create();
        $book = Book::create([
            'title' => 'Inertia Props Book ' . uniqid(),
            'cover_path' => 'covers/unit_test_cover.jpg',
            'file_path' => 'books/unit_test_book.pdf',
        ]);

        $this->createdFiles[] = $book->cover_path;
        $this->createdFiles[] = $book->file_path;

        $response = $this->actingAs($user)->get(route('books.show', $book));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($book) {
            $page->component('Books/Show')
                ->has('book')
                ->where('book.cover_path', 'covers/unit_test_cover.jpg')
                ->where('book.file_path', 'books/unit_test_book.pdf');
        });

        // Clean up test book
        $book->delete();
    }

    /**
     * Test 7: Validation rejects invalid file extensions (non-PDF for books)
     */
    public function test_book_upload_validation_rejects_non_pdf_file()
    {
        $user = User::factory()->create();

        $invalidFile = UploadedFile::fake()->create('not_a_book.txt', 10, 'text/plain');

        $response = $this->actingAs($user)->post(route('books.store'), [
            'title' => 'Invalid Book ' . uniqid(),
            'file' => $invalidFile,
        ]);

        $response->assertSessionHasErrors(['file']);
    }
}

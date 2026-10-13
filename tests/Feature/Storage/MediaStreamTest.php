<?php

namespace Tests\Feature\Storage;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class MediaStreamTest extends TestCase
{
    protected array $createdFiles = [];
    protected array $createdDirs = [];

    protected function tearDown(): void
    {
        foreach ($this->createdFiles as $file) {
            if (file_exists($file)) {
                @unlink($file);
            }
        }

        foreach ($this->createdDirs as $dir) {
            if (is_dir($dir)) {
                @rmdir($dir);
            }
        }

        parent::tearDown();
    }

    protected function createMediaFile(string $relativePath, int $sizeBytes): string
    {
        $fullPath = storage_path('app/public/' . $relativePath);
        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            $this->createdDirs[] = $dir;
        }

        $header = str_ends_with($relativePath, '.mp4')
            ? "\x00\x00\x00\x1cftypisom\x00\x00\x02\x00isomiso2mp41"
            : '';

        $padding = max(0, $sizeBytes - strlen($header));
        file_put_contents($fullPath, $header . str_repeat('X', $padding));
        $this->createdFiles[] = $fullPath;

        return $fullPath;
    }

    public function test_stream_returns_404_when_video_or_audio_not_found(): void
    {
        $videoResponse = $this->get('/stream/videos/non_existent_video_99999.mp4');
        $videoResponse->assertStatus(404);

        $audioResponse = $this->get('/stream/audio/non_existent_audio_99999.mp3');
        $audioResponse->assertStatus(404);
    }

    public function test_stream_video_full_content_status_200(): void
    {
        $this->createMediaFile('videos/test_stream_video.mp4', 10000);

        $response = $this->get('/stream/videos/test_stream_video.mp4');

        $response->assertStatus(200);
        $response->assertHeader('Accept-Ranges', 'bytes');
        $response->assertHeader('Content-Length', '10000');
        $response->assertHeader('Content-Type', 'video/mp4');
    }

    public function test_stream_video_with_range_request_status_206(): void
    {
        $this->createMediaFile('videos/test_stream_video.mp4', 10000);

        $response = $this->get('/stream/videos/test_stream_video.mp4', [
            'Range' => 'bytes=0-1023',
        ]);

        $response->assertStatus(206);
        $response->assertHeader('Content-Range', 'bytes 0-1023/10000');
        $response->assertHeader('Content-Length', '1024');
    }

    public function test_stream_audio_full_content_status_200(): void
    {
        $this->createMediaFile('imports/test_stream_audio.mp3', 5000);

        $response = $this->get('/stream/audio/test_stream_audio.mp3');

        $response->assertStatus(200);
        $response->assertHeader('Accept-Ranges', 'bytes');
        $response->assertHeader('Content-Length', '5000');
    }

    public function test_stream_audio_with_range_request_status_206(): void
    {
        $this->createMediaFile('imports/test_stream_audio.mp3', 5000);

        $response = $this->get('/stream/audio/test_stream_audio.mp3', [
            'Range' => 'bytes=500-1499',
        ]);

        $response->assertStatus(206);
        $response->assertHeader('Content-Range', 'bytes 500-1499/5000');
        $response->assertHeader('Content-Length', '1000');
    }

    public function test_stream_resolves_file_when_direct_relative_path_is_supplied(): void
    {
        $this->createMediaFile('custom_folder/direct_media.mp4', 8000);

        $response = $this->get('/stream/videos/custom_folder/direct_media.mp4');

        $response->assertStatus(200);
        $response->assertHeader('Content-Length', '8000');
    }

    public function test_stream_aborts_404_if_path_is_a_directory(): void
    {
        $dirPath = storage_path('app/public/test_stream_dir');
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
            $this->createdDirs[] = $dirPath;
        }

        $response = $this->get('/stream/videos/test_stream_dir');
        $response->assertStatus(404);
    }
}

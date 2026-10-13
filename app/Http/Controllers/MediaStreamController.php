<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaStreamController extends Controller
{
    /**
     * Stream a video file with range request support for seeking.
     */
    public function streamVideo(Request $request, string $path): StreamedResponse
    {
        return $this->streamMedia($request, $path, 'videos/', 'video/mp4');
    }

    /**
     * Stream an audio file with range request support for seeking.
     */
    public function streamAudio(Request $request, string $path): StreamedResponse
    {
        return $this->streamMedia($request, $path, 'imports/', 'audio/mpeg');
    }

    /**
     * Stream a media file with range request support (HTTP 206 Partial Content).
     */
    protected function streamMedia(
        Request $request,
        string $path,
        string $fallbackPrefix,
        string $defaultMimeType
    ): StreamedResponse {
        $fullPath = storage_path('app/public/' . $path);

        // Fallback: If not found, try prepending the fallback directory prefix
        if (!file_exists($fullPath) && !str_starts_with($path, $fallbackPrefix)) {
            $fullPath = storage_path('app/public/' . $fallbackPrefix . $path);
        }

        if (!file_exists($fullPath) || is_dir($fullPath)) {
            abort(404);
        }

        $size = filesize($fullPath);
        $detectedMime = @mime_content_type($fullPath);
        $mimeType = ($detectedMime && !in_array($detectedMime, ['text/plain', 'application/octet-stream']))
            ? $detectedMime
            : $defaultMimeType;

        $start = 0;
        $end = $size - 1;
        $length = $size;

        // Handle range requests for seeking support (RFC 7233)
        if ($request->header('Range')) {
            $range = $request->header('Range');

            if (preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
                $start = intval($matches[1]);
                $end = $matches[2] !== '' ? intval($matches[2]) : $end;
                $length = $end - $start + 1;
            }
        }

        $response = new StreamedResponse(function () use ($fullPath, $start, $length) {
            $stream = fopen($fullPath, 'rb');
            fseek($stream, $start);

            $chunkSize = 8192; // 8KB chunks
            $bytesRead = 0;

            while (!feof($stream) && $bytesRead < $length) {
                $bytesToRead = min($chunkSize, $length - $bytesRead);
                echo fread($stream, $bytesToRead);
                $bytesRead += $bytesToRead;
                flush();
            }

            fclose($stream);
        }, $request->header('Range') ? 206 : 200);

        $response->headers->set('Content-Type', $mimeType);
        $response->headers->set('Content-Length', $length);
        $response->headers->set('Accept-Ranges', 'bytes');
        $response->headers->set('Cache-Control', 'public, max-age=31536000');

        if ($request->header('Range')) {
            $response->headers->set('Content-Range', "bytes {$start}-{$end}/{$size}");
        }

        return $response;
    }
}

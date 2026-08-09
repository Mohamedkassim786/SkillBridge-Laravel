<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaStreamController extends Controller
{
    public function stream(Request $request, string $path)
    {
        $path = rawurldecode($path);
        $path = str_replace(['..', '\\'], ['', '/'], $path);
        
        $filePath = storage_path('app/public/' . $path);
        if (!file_exists($filePath)) {
            $filePath = public_path($path);
        }

        if (!file_exists($filePath) || !is_file($filePath)) {
            $filePath = storage_path('app/' . $path);
        }

        if (!file_exists($filePath) || !is_file($filePath)) {
            abort(404, 'Media file not found');
        }

        $size = filesize($filePath);
        $mime = mime_content_type($filePath) ?: 'video/mp4';

        $file = fopen($filePath, 'rb');
        $start = 0;
        $end = $size - 1;

        $headers = [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-cache, private',
        ];

        if ($request->headers->has('Range')) {
            $range = $request->header('Range');
            if (preg_match('/bytes=(\d+)-(\d+)?/', $range, $matches)) {
                $start = intval($matches[1]);
                if (isset($matches[2]) && $matches[2] !== '') {
                    $end = intval($matches[2]);
                }
            }

            $length = $end - $start + 1;
            fseek($file, $start);

            $headers['Content-Range'] = sprintf('bytes %d-%d/%d', $start, $end, $size);
            $headers['Content-Length'] = $length;

            return response()->stream(function () use ($file, $length) {
                $bufferSize = 1024 * 128;
                $bytesLeft = $length;
                while ($bytesLeft > 0 && !feof($file)) {
                    $readSize = min($bufferSize, $bytesLeft);
                    echo fread($file, $readSize);
                    flush();
                    $bytesLeft -= $readSize;
                }
                fclose($file);
            }, 206, $headers);
        }

        $headers['Content-Length'] = $size;

        return response()->stream(function () use ($file, $size) {
            $bufferSize = 1024 * 128;
            while (!feof($file)) {
                echo fread($file, $bufferSize);
                flush();
            }
            fclose($file);
        }, 200, $headers);
    }
}

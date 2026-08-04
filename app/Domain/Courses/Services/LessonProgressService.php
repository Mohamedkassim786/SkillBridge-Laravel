<?php

namespace App\Domain\Courses\Services;

use App\Models\LessonProgress;
use Illuminate\Support\Facades\Redis;

class LessonProgressService
{
    /**
     * Buffer student video watch time in Redis to avoid database write locking.
     */
    public function bufferProgress(string $userId, string $lessonId, int $watchTimeSeconds, int $durationSeconds): void
    {
        $percentage = min(100, (int) round(($watchTimeSeconds / max(1, $durationSeconds)) * 100));
        $cacheKey = "progress:{$userId}:{$lessonId}";

        Redis::hset($cacheKey, 'user_id', $userId);
        Redis::hset($cacheKey, 'lesson_id', $lessonId);
        Redis::hset($cacheKey, 'watch_time_seconds', $watchTimeSeconds);
        Redis::hset($cacheKey, 'watch_percentage', $percentage);
        Redis::hset($cacheKey, 'is_completed', $percentage >= 90 ? 1 : 0);
    }

    /**
     * Flush buffered progress updates directly to MySQL in bulk.
     */
    public function syncBufferedProgressToDatabase(string $userId, string $lessonId): LessonProgress
    {
        $cacheKey = "progress:{$userId}:{$lessonId}";
        $data = Redis::hgetall($cacheKey);

        if (empty($data)) {
            return LessonProgress::firstOrCreate([
                'user_id' => $userId,
                'lesson_id' => $lessonId,
            ]);
        }

        return LessonProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
            ],
            [
                'watch_time_seconds' => (int) ($data['watch_time_seconds'] ?? 0),
                'watch_percentage' => (int) ($data['watch_percentage'] ?? 0),
                'is_completed' => (bool) ($data['is_completed'] ?? false),
            ]
        );
    }
}

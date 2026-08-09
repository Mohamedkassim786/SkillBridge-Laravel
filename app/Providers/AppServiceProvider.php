<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Auth\Contracts\UserRepositoryInterface::class,
            \App\Domain\Auth\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Domain\Auth\Contracts\UserProfileRepositoryInterface::class,
            \App\Domain\Auth\Repositories\UserProfileRepository::class
        );
        $this->app->bind(
            \App\Domain\Auth\Contracts\LoginHistoryRepositoryInterface::class,
            \App\Domain\Auth\Repositories\LoginHistoryRepository::class
        );
        $this->app->bind(
            \App\Domain\Student\Contracts\StudentDashboardRepositoryInterface::class,
            \App\Domain\Student\Repositories\StudentDashboardRepository::class
        );
        $this->app->bind(
            \App\Domain\Student\Contracts\CourseRepositoryInterface::class,
            \App\Domain\Student\Repositories\CourseRepository::class
        );
        $this->app->bind(
            \App\Domain\Student\Contracts\LessonRepositoryInterface::class,
            \App\Domain\Student\Repositories\LessonRepository::class
        );
        $this->app->bind(
            \App\Domain\Student\Contracts\LessonNotesRepositoryInterface::class,
            \App\Domain\Student\Repositories\LessonNotesRepository::class
        );
        $this->app->bind(
            \App\Domain\Student\Contracts\LessonBookmarkRepositoryInterface::class,
            \App\Domain\Student\Repositories\LessonBookmarkRepository::class
        );
        $this->app->bind(
            \App\Domain\Student\Contracts\CourseReviewRepositoryInterface::class,
            \App\Domain\Student\Repositories\CourseReviewRepository::class
        );
        $this->app->bind(
            \App\Domain\Ai\Interview\Contracts\VoiceInterviewProviderInterface::class,
            \App\Domain\Ai\Interview\Providers\NvidiaNemotronVoiceChatProvider::class
        );
        $this->app->bind(
            \App\Domain\Ai\Interview\Contracts\InterviewEvaluationServiceInterface::class,
            \App\Domain\Ai\Interview\Services\InterviewEvaluationService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || env('APP_ENV') === 'production' || str_contains(request()->header('x-forwarded-proto', ''), 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by(strtolower((string) $request->input('email')).'|'.$request->ip()));
        RateLimiter::for('registration', fn (Request $request) => Limit::perMinute(3)->by($request->ip()));
    }
}

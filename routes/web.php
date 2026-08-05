<?php

use App\Domain\Auth\Services\RoleRedirectionService;
use App\Livewire\Auth\AccessDenied;
use App\Livewire\Auth\AccountSuspended;
use App\Livewire\Auth\ChangePassword;
use App\Livewire\Auth\CompleteProfile;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\MaintenanceMode;
use App\Livewire\Auth\ProfileSettings;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\SessionExpired;
use App\Livewire\Auth\SessionManager;
use App\Livewire\Auth\TooManyAttempts;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Auth\VerifyFailed;
use App\Livewire\Auth\VerifySuccess;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Enterprise LMS Website Routes
|--------------------------------------------------------------------------
*/
Route::get('/', \App\Livewire\Public\Home::class)->name('home');
Route::get('/courses', \App\Livewire\Public\Courses\Index::class)->name('courses.index');
Route::get('/courses/{courseId}', \App\Livewire\Public\Courses\Show::class)->name('courses.show');

Route::get('/categories', \App\Livewire\Public\Categories\Index::class)->name('categories.index');
Route::get('/categories/{slug}', \App\Livewire\Public\Categories\Show::class)->name('categories.show');

Route::get('/instructors', \App\Livewire\Public\Instructors\Index::class)->name('instructors.index');
Route::get('/instructors/{id}', \App\Livewire\Public\Instructors\Show::class)->name('instructors.show');

Route::get('/jobs', \App\Livewire\Public\Jobs\Index::class)->name('jobs.index');
Route::get('/jobs/{id}', \App\Livewire\Public\Jobs\Show::class)->name('jobs.show');

Route::get('/pricing', \App\Livewire\Public\Pricing::class)->name('pricing');
Route::get('/success-stories', \App\Livewire\Public\SuccessStories::class)->name('success.stories');

Route::get('/blog', \App\Livewire\Public\Blog\Index::class)->name('blog.index');
Route::get('/blog/{slug}', \App\Livewire\Public\Blog\Show::class)->name('blog.show');

Route::get('/events', \App\Livewire\Public\Events\Index::class)->name('events.index');
Route::get('/about', \App\Livewire\Public\About::class)->name('about');
Route::get('/contact', \App\Livewire\Public\Contact::class)->name('contact');
Route::get('/faq', \App\Livewire\Public\Faq::class)->name('faq');

/*
|--------------------------------------------------------------------------
| Guest Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

// Email Verification Notice & Handlers
Route::get('/verify-email', VerifyEmail::class)->name('verification.notice');
Route::get('/verify-email/success', VerifySuccess::class)->name('verification.success');
Route::get('/verify-email/failed', VerifyFailed::class)->name('verification.failed');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    $user = $request->user();
    if ($user) {
        $user->update(['status' => 'active']);
    }
    return redirect()->route('verification.success');
})->middleware(['auth', 'signed'])->name('verification.verify');

// System Exception & Status Notice Routes
Route::get('/account-suspended', AccountSuspended::class)->name('account.suspended');
Route::get('/too-many-login-attempts', TooManyAttempts::class)->name('too.many.attempts');
Route::get('/maintenance', MaintenanceMode::class)->name('maintenance');
Route::get('/session-expired', SessionExpired::class)->name('session.expired');
Route::get('/403', AccessDenied::class)->name('access.denied');

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard & Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('status', 'You have been signed out.');
    })->name('logout');

    Route::get('/complete-profile', CompleteProfile::class)->name('profile.complete');

    Route::get('/settings/profile', ProfileSettings::class)->name('profile.settings');
    Route::get('/settings/change-password', ChangePassword::class)->name('password.change');
    Route::get('/settings/sessions', SessionManager::class)->name('sessions.manage');

    // Centralized Dashboard Redirector
    Route::get('/dashboard', function (RoleRedirectionService $roleService) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return redirect()->to($roleService->getRedirectPath($user));
    })->name('dashboard');

    // Admin & Super Admin Management Routes
    Route::middleware('role:super_admin')->get('/super-admin/dashboard', function () {
        return view('welcome', ['roleTitle' => 'Super Admin Dashboard']);
    })->name('super_admin.dashboard');

    Route::middleware('role:admin|super_admin')->group(function () {
        Route::get('/admin/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
        Route::get('/admin/users', \App\Livewire\Admin\Users\Index::class)->name('admin.users.index');
        Route::get('/admin/courses', \App\Livewire\Admin\Courses\Manage::class)->name('admin.courses.manage');
        Route::get('/admin/jobs', \App\Livewire\Admin\Jobs\Manage::class)->name('admin.jobs.manage');
        Route::get('/admin/companies', \App\Livewire\Admin\Companies\Manage::class)->name('admin.companies.manage');
        Route::get('/admin/applications', \App\Livewire\Admin\Applications\Manage::class)->name('admin.applications.manage');
        Route::get('/admin/payments', \App\Livewire\Admin\Payments\Manage::class)->name('admin.payments.manage');
        Route::get('/admin/reports', \App\Livewire\Admin\Reports\Index::class)->name('admin.reports.index');
        Route::get('/admin/settings', \App\Livewire\Admin\Settings\Index::class)->name('admin.settings.index');
        Route::get('/admin/backups', \App\Livewire\Admin\Backups\Index::class)->name('admin.backups.index');
        Route::get('/admin/activity-logs', \App\Livewire\Admin\ActivityLogs\Index::class)->name('admin.activity-logs.index');
        Route::get('/admin/lessons', \App\Livewire\Admin\Lessons\Manage::class)->name('admin.lessons.manage');
        Route::get('/admin/enrollments', \App\Livewire\Admin\Enrollments\Manage::class)->name('admin.enrollments.manage');
        Route::get('/admin/cms', \App\Livewire\Admin\Cms\Manage::class)->name('admin.cms.manage');
    });

    Route::middleware('role:staff|trainer')->get('/staff/dashboard', function () {
        return view('welcome', ['roleTitle' => 'Staff / Trainer Dashboard']);
    })->name('staff.dashboard');

    // Student Dashboard & Course Player Routes
    Route::middleware(['role:student', 'profile.completed'])->group(function () {
        Route::get('/student/dashboard', \App\Livewire\Student\Dashboard::class)->name('student.dashboard');
        Route::get('/student/courses', \App\Livewire\Student\Courses\Index::class)->name('student.courses.index');
        Route::get('/student/courses/{courseId}', \App\Livewire\Student\Courses\Show::class)->name('student.courses.show');
        Route::get('/student/courses/{courseId}/learn/{lesson?}', \App\Livewire\Student\Courses\Player::class)->name('student.courses.player');

        Route::get('/student/certificates/{id}/view', [\App\Http\Controllers\Student\CertificateController::class, 'view'])->name('student.certificates.view');
        Route::get('/student/certificates/{id}/download', [\App\Http\Controllers\Student\CertificateController::class, 'download'])->name('student.certificates.download');
    });
});

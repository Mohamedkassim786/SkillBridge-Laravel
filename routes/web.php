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

// Public Home Route
Route::get('/', function () {
    return view('welcome');
});

// Guest Authentication Routes
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

// Exception & System Status Notice Routes
Route::get('/account-suspended', AccountSuspended::class)->name('account.suspended');
Route::get('/too-many-login-attempts', TooManyAttempts::class)->name('too.many.attempts');
Route::get('/maintenance', MaintenanceMode::class)->name('maintenance');
Route::get('/session-expired', SessionExpired::class)->name('session.expired');
Route::get('/403', AccessDenied::class)->name('access.denied');

// Authenticated Routes
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

    // 4 Role-Based Dashboards
    Route::middleware('role:super_admin')->get('/super-admin/dashboard', function () {
        return view('welcome', ['roleTitle' => 'Super Admin Dashboard']);
    })->name('super_admin.dashboard');

    Route::middleware('role:admin')->get('/admin/dashboard', function () {
        return view('welcome', ['roleTitle' => 'Admin Dashboard']);
    })->name('admin.dashboard');

    Route::middleware('role:staff,trainer')->get('/staff/dashboard', function () {
        return view('welcome', ['roleTitle' => 'Staff / Trainer Dashboard']);
    })->name('staff.dashboard');

    Route::middleware(['role:student', 'profile.completed'])->group(function () {
        Route::get('/student/dashboard', \App\Livewire\Student\Dashboard::class)->name('student.dashboard');
        Route::get('/student/courses', \App\Livewire\Student\Courses\Index::class)->name('student.courses.index');
        Route::get('/student/courses/{courseId}', \App\Livewire\Student\Courses\Show::class)->name('student.courses.show');
        Route::get('/student/courses/{courseId}/learn/{lesson?}', \App\Livewire\Student\Courses\Player::class)->name('student.courses.player');
    });
});

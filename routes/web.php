<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternshipApplicationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

    // Password Reset
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:3,1');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// ── Auth Routes ──
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Redirect /dashboard to role-specific dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        if ($user->hasRole('dosen')) return redirect()->route('dosen.dashboard');
        if ($user->hasRole('perusahaan')) return redirect()->route('perusahaan.dashboard');
        return redirect()->route('mahasiswa.dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Notifications
    Route::get('/notifikasi', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // ── Mahasiswa Routes ──
    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])->name('dashboard');
        
        // Applications
        Route::get('/applications', [InternshipApplicationController::class, 'indexMahasiswa'])->name('applications.index');
        Route::get('/applications/create', [InternshipApplicationController::class, 'create'])->name('applications.create');
        Route::post('/applications', [InternshipApplicationController::class, 'store'])->name('applications.store');
        
        require base_path('routes/mahasiswa.php');
    });

    // ── Dosen Routes ──
    Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dosen'])->name('dashboard');
        
        require base_path('routes/dosen.php');
    });

    // ── Admin Routes ──
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        
        // Applications
        Route::get('/applications', [InternshipApplicationController::class, 'indexAdmin'])->name('applications.index');
        Route::get('/applications/{application}', [InternshipApplicationController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/approve', [InternshipApplicationController::class, 'approve'])->name('applications.approve');
        Route::post('/applications/{application}/reject', [InternshipApplicationController::class, 'reject'])->name('applications.reject');
        Route::get('/applications/{application}/surat-pdf', [InternshipApplicationController::class, 'generatePdf'])->name('applications.pdf');
        Route::get('/applications/{application}/documents/{document}/download', [InternshipApplicationController::class, 'downloadDocument'])->name('applications.documents.download');
        
        // Attendances
        Route::get('/presensi', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendances.index');

        // Reports
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/attendances/export', [App\Http\Controllers\Admin\ReportController::class, 'exportAttendances'])->name('reports.attendances.export');
        Route::get('/reports/assessments/export', [App\Http\Controllers\Admin\ReportController::class, 'exportAssessments'])->name('reports.assessments.export');
        Route::get('/reports/pdf/{application?}', [App\Http\Controllers\Admin\ReportController::class, 'downloadPdf'])->name('reports.pdf');
        
        require base_path('routes/admin.php');
    });

    // ── Perusahaan Routes ──
    Route::middleware('role:perusahaan')->prefix('perusahaan')->name('perusahaan.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'perusahaan'])->name('dashboard');
        
        // Attendances
        Route::get('/presensi/scanner', [App\Http\Controllers\Perusahaan\AttendanceController::class, 'scanner'])->name('attendances.scanner');
        Route::post('/presensi/verify', [App\Http\Controllers\Perusahaan\AttendanceController::class, 'verify'])->name('attendances.verify');
        Route::get('/presensi', [App\Http\Controllers\Perusahaan\AttendanceController::class, 'index'])->name('attendances.index');
        
        // Assessments
        Route::get('/penilaian', [App\Http\Controllers\Perusahaan\AssessmentController::class, 'index'])->name('assessments.index');
        Route::post('/penilaian/{application}', [App\Http\Controllers\Perusahaan\AssessmentController::class, 'store'])->name('assessments.store');
    });
});

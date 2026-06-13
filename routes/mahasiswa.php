<?php

use App\Http\Controllers\Mahasiswa\LogbookController;
use Illuminate\Support\Facades\Route;

// Prefix: /mahasiswa
// Middleware: role:mahasiswa

Route::get('/logbooks', [LogbookController::class, 'index'])->name('logbooks.index');
Route::get('/logbooks/create', [LogbookController::class, 'create'])->name('logbooks.create');
Route::post('/logbooks', [LogbookController::class, 'store'])->name('logbooks.store');
Route::get('/logbooks/{logbook}/edit', [LogbookController::class, 'edit'])->name('logbooks.edit');
Route::put('/logbooks/{logbook}', [LogbookController::class, 'update'])->name('logbooks.update');

use App\Http\Controllers\Mahasiswa\AttendanceController;

Route::get('/presensi', [AttendanceController::class, 'index'])->name('attendances.index');
Route::post('/presensi/generate', [AttendanceController::class, 'generateQr'])->name('attendances.generate');

use App\Http\Controllers\Mahasiswa\AssessmentController;
use App\Http\Controllers\Mahasiswa\DocumentController;

Route::get('/penilaian', [AssessmentController::class, 'index'])->name('assessments.index');

Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
Route::get('/documents/surat/{application}', [DocumentController::class, 'downloadSurat'])->name('documents.surat');
Route::get('/documents/sertifikat/{application}', [DocumentController::class, 'downloadSertifikat'])->name('documents.sertifikat');

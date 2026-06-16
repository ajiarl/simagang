<?php

use App\Http\Controllers\Dosen\LogbookController;
use App\Http\Controllers\Dosen\AssessmentController;
use Illuminate\Support\Facades\Route;

// Prefix: /dosen
// Middleware: role:dosen

Route::get('/logbooks', [LogbookController::class, 'index'])->name('logbooks.index');
Route::get('/logbooks/{student_id}', [LogbookController::class, 'showStudent'])->name('logbooks.student');
Route::post('/logbooks/{logbook}/review', [LogbookController::class, 'review'])->name('logbooks.review');

Route::get('/penilaian', [AssessmentController::class, 'index'])->name('assessments.index');
Route::post('/penilaian/{application}', [AssessmentController::class, 'store'])->name('assessments.store');

use App\Http\Controllers\Dosen\StudentController;

Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/{application}', [StudentController::class, 'show'])->name('students.show');

<?php

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\PeriodController;
use Illuminate\Support\Facades\Route;

// All routes here are already prefixed with 'admin.' and have 'role:admin' middleware

// Manajemen Mahasiswa
Route::resource('students', StudentController::class)->except(['destroy']);

// Manajemen Dosen
Route::resource('lecturers', LecturerController::class)->except(['destroy']);

// Manajemen Perusahaan
Route::resource('companies', CompanyController::class);

// Manajemen Periode Magang
Route::resource('periods', PeriodController::class)->except(['destroy', 'show']);

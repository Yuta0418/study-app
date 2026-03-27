<?php

use App\Http\Controllers\ExamAnalysisController;
use App\Http\Controllers\StudyRecordController;
use App\Http\Controllers\MockExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('exams.index') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/exams/{exam}/analysis', [ExamAnalysisController::class, 'index'])->name('analysis.index');
    Route::get('/exams/list', [ExamController::class, 'list'])->name('exams.list');
    Route::resource('exams', ExamController::class);
    Route::resource('exams.study-records', StudyRecordController::class);
    Route::resource('exams.mock-exams', MockExamController::class);
});

require __DIR__ . '/auth.php';

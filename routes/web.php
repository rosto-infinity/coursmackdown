<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cours', [CoursController::class, 'index'])->name('cours.index');
Route::get('/cours/{nomCours}', [CoursController::class, 'show'])->name('cours.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\DisasterLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::get('/', fn () => redirect()->route('disasters.index'))->name('home');

// =====================
// 1. PUBLIC ROUTES
// =====================
Route::get('/disasters', [DisasterController::class, 'index'])
    ->name('disasters.index');

Route::get('/disasters/search-ajax', [DisasterController::class, 'searchAjax'])
    ->name('disasters.search-ajax');

// =====================
// 2. AUTH (admin + partner) – CRUD bencana & profile
// =====================
Route::middleware(['auth','verified'])->group(function () {

    // resource tanpa index & show (itu sudah didefinisikan di atas / bawah)
    Route::resource('disasters', DisasterController::class)
        ->except(['index','show']);

    Route::get('/my-disasters', [DisasterController::class, 'myDisasters'])
        ->name('disasters.my');

    // Profile
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================
// 3. ADMIN ONLY
// =====================
Route::middleware(['auth','verified','admin'])->group(function () {

    Route::post('disasters/{disaster}/approve', [DisasterController::class,'approve'])
        ->name('disasters.approve');

    Route::post('disasters/{disaster}/close', [DisasterController::class,'close'])
        ->name('disasters.close');

    Route::post('disasters/{disaster:slug}/links', [DisasterLinkController::class,'store'])
        ->name('disasters.links.store');

    Route::delete('disasters/{disaster:slug}/links/{link}', [DisasterLinkController::class,'destroy'])
        ->name('disasters.links.destroy');

    // Manajemen user
    Route::get ('users',            [UserController::class, 'index'])->name('users.index');
    Route::get ('users/create',     [UserController::class, 'create'])->name('users.create');
    Route::post('users',            [UserController::class, 'store'])->name('users.store');
    Route::get ('users/{user}/edit',[UserController::class, 'edit'])->name('users.edit');
    Route::put ('users/{user}',     [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}',   [UserController::class, 'destroy'])->name('users.destroy');
});

// =====================
// 4. SHOW DETAIL (pakai slug) – letakkan PALING BAWAH
// =====================
Route::get('/disasters/{disaster:slug}', [DisasterController::class, 'show'])
    ->name('disasters.show');

require __DIR__.'/auth.php';

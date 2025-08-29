<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('/')->group(function () {
    // books
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/search', [BookController::class, 'search'])->name('books.search');

    // register user
    Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    // Rotas para login
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Rotas de perfil
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // temporary routes for login, logout, and profile edit (to be implemented later)
    Route::get('/profile/edit', function () {
        return 'Página de edição de perfil (em construção)';
    })->name('profile.edit');

    // Rota de logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// search books
Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/search', [BookController::class, 'search'])->name('books.search');

// register user
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Route::middleware(['auth'])->group(function () {
//     // Rotas de perfil protegidas
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

//     // Rota de logout
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//     // Rota do dashboard para redirecionamento após o login
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

// // Rotas para login (se a página de login existir)
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);

// temporary routes for login, logout, and profile edit (to be implemented later)
Route::get('/login', function () {
    return 'Página de login (em construção)';
})->name('login');
Route::post('/logout', function () {
    return 'Logout (em construção)';
})->name('logout');
Route::get('/profile/edit', function () {
    return 'Página de edição de perfil (em construção)';
})->name('profile.edit');


// Route::get('/', function () {
//     return view('welcome');
// });

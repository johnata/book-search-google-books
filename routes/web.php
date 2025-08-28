<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/search', [BookController::class, 'search'])->name('books.search');

// Route::get('/', function () {
//     return view('welcome');
// });

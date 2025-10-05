<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
Route::resource('posts', App\Http\Controllers\PostController::class);

Route::resource('product', ProductController::class);

Route::get('/hello', function () {
    return "Hello, World!";
});

Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{name?}', function ($name = "Guest") {
    return "Hello, " . $name;
});

Route::get('/profile-public', function () {
    return "Ini page profile dari modul 2";
})->name('profile.public');

Route::get('/redirect-to-profile', function () {
    return redirect()->route('profile.public');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Admin Dashboard";
    });
    Route::get('/profile', function () {
        return "Admin Profile";
    });
});

// Rute untuk menampilkan form 'Create New Product'
Route::get('/product/create', [ProductController::class, 'create'])->name('product-create');

// Rute untuk menyimpan data yang dikirim dari form
Route::post('/product', [ProductController::class, 'store'])->name('product-store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'RoleCheck:admin'])->name('dashboard');

Route::middleware('auth', 'verified', 'RoleCheck:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

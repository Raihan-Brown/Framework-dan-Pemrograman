<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;

// Route Resource Posts tetap dipertahankan
Route::resource('posts', PostController::class);

// Route::resource('product', ProductController::class); // BARIS INI DIHAPUS UNTUK MENGHINDARI KONFLIK

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

// --- ROUTE PRODUCT MANUAL UNTUK MEMASTIKAN NAMA 'product-store' ADA ---

// Rute untuk menampilkan daftar produk (Index)
Route::get('/product', [ProductController::class, 'index'])->name('product.index');

// Rute untuk menampilkan form 'Create New Product'
Route::get('/product/create', [ProductController::class, 'create'])->name('product-create');

// Rute untuk menyimpan data yang dikirim dari form (POST)
Route::post('/product', [ProductController::class, 'store'])->name('product-store');

// Rute untuk Edit dan Delete (tambahan untuk melengkapi CRUD)
// Asumsi Anda juga butuh ini, menggunakan nama yang konsisten dengan dash
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product-edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product-update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product-delete');

// --- END ROUTE PRODUCT ---


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'RoleCheck:admin'])->name('dashboard');

Route::middleware('auth', 'verified', 'RoleCheck:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

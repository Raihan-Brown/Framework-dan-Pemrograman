<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;

// Route Resource Posts tetap dipertahankan
Route::resource('posts', PostController::class);

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

// --- ROUTE PRODUCT MANUAL (CRUD LENGKAP) ---
// Perbaikan: Menghapus duplikasi rute dan memastikan semua nama rute konsisten
// (product-index, product-create, product-detail, dll.)

// 1. Index (Menampilkan daftar produk)
Route::get('/product', [ProductController::class, 'index'])->name('product-index');

// 2. Create (Form tambah produk)
Route::get('/product/create', [ProductController::class, 'create'])->name('product-create');

// 3. Store (Menyimpan data baru)
Route::post('/product', [ProductController::class, 'store'])->name('product-store');

// 4. Detail (Menampilkan detail satu produk)
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product-detail');

// 5. Edit (Form edit produk)
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product-edit');

// 6. Update (Mengupdate data)
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product-update');

// 7. Destroy (Menghapus data)
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

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;

// --- SEMUA ROUTE PUBLIC (TIDAK PERLU LOGIN) ---

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

// --- END ROUTE PUBLIC ---

// --- SEMUA ROUTE YANG PERLU LOGIN & ROLE ADMIN ---
Route::middleware(['auth', 'verified', 'RoleCheck:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ROUTE PRODUCT (CRUD) ---
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
    
    // Route Export
    Route::get('/product/export/excel', [ProductController::class, 'exportExcel'])->name('product-export-excel');

    // Route untuk PDF
    Route::get('/reports/stock-mutation/pdf', [ProductController::class, 'exportStockPdf'])->name('reports.stock-mutation.pdf');

});
// --- END GROUP AUTH ---


// Rute untuk Login, Register, dll (HARUS DI LUAR)
require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Import semua controller admin Anda
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AchievementsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AkunController;


Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    // Arahkan /dashboard ke halaman Posts sebagai halaman default admin
    return redirect()->route('admin.posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- KELOMPOK ROUTE UNTUK ADMIN ---
// Semua URL di sini akan diawali dengan /admin/ dan memerlukan login
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Route untuk Posts (Berita)
    // URL: /admin/posts
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');

    // Route untuk Achievements (Prestasi)
    // URL: /admin/achievements
    Route::get('/achievements', [AchievementsController::class, 'index'])->name('achievements.index');

    // Anda bisa menambahkan route untuk Dashboard dan Akun di sini saat controllernya sudah siap
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');

});


// Route untuk profile user (biasanya terpisah)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

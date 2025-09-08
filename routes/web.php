<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Import semua controller yang relevan
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AchievementsController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\PublicAchievementController; // <-- Impor controller baru
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- KELOMPOK ROUTE PUBLIK ---

Route::get('/', function () {
    // Ambil 3 berita terbaru KECUALI Prestasi
    $latestPosts = Post::where('category', '!=', 'Prestasi')
        ->where('status', 'Terbitkan')
        ->latest('published_at')
        ->take(3)
        ->get();

    // Ambil 3 berita Prestasi terbaru
    $latestAchievements = Post::where('category', 'Prestasi')
        ->where('status', 'Terbitkan')
        ->latest('published_at')
        ->take(3)
        ->get();

    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'latestPosts' => $latestPosts,
        'latestAchievements' => $latestAchievements,
    ]);
})->name('home');

// Route untuk menampilkan daftar semua berita
Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');

// Route untuk menampilkan satu berita berdasarkan slug-nya
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('berita.show');

// PERUBAHAN: Tambahkan route untuk halaman Prestasi Mahasiswa
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('prestasi.index');


// --- KELOMPOK ROUTE UNTUK ADMIN ---
// Semua URL di sini akan diawali dengan /admin/ dan memerlukan login
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Route untuk Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard/Index');
    })->name('dashboard');

    // Resource Routes untuk CRUD Posts (Berita) dan Achievements (Prestasi)
    Route::resource('/posts', AdminPostController::class);
    Route::resource('/achievements', AchievementsController::class);

    // Route untuk Impor & Ekspor Prestasi
    Route::post('/achievements/import', [AchievementsController::class, 'import'])->name('achievements.import');
    Route::get('/achievements/export', [AchievementsController::class, 'export'])->name('achievements.export');
});


// --- KELOMPOK ROUTE UNTUK AUTENTIKASI ---

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Arahkan /dashboard default Laravel ke dashboard admin kita
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Impor route-route autentikasi standar (login, register, dll.)
require __DIR__ . '/auth.php';
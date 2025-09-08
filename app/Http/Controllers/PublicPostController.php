<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPostController extends Controller
{
    /**
     * Menampilkan halaman daftar berita publik dengan filter.
     */
    public function index(Request $request)
    {
        $query = Post::where('status', 'Terbitkan');

        // Terapkan filter pencarian jika ada
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Terapkan filter kategori jika ada
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Ambil data setelah difilter, urutkan, dan paginasi
        $posts = $query->latest('published_at')->paginate(9)->withQueryString();

        return Inertia::render('Public/Berita/Index', [
            'posts' => $posts,
            'recentPosts' => Post::where('status', 'Terbitkan')->latest('published_at')->take(5)->get(),
            'categories' => Post::where('status', 'Terbitkan')->distinct()->pluck('category')->all(),
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    /**
     * Menampilkan halaman detail untuk satu berita.
     */
    public function show(Post $post)
    {
        // Pastikan hanya berita yang sudah "Terbitkan" yang bisa diakses publik.
        if ($post->status !== 'Terbitkan') {
            abort(404);
        }

        // Tambah jumlah 'views' setiap kali berita ini dilihat.
        $post->increment('views');

        // PERBAIKAN: Ambil berita terbaru lainnya untuk sidebar
        $recentPosts = Post::where('status', 'Terbitkan')
            ->where('id', '!=', $post->id) // Kecualikan berita yang sedang dibaca
            ->latest('published_at')
            ->take(5)
            ->get();

        return Inertia::render('Public/Berita/Show', [
            'post' => $post,
            'recentPosts' => $recentPosts, // Kirim data berita terbaru ke view
        ]);
    }
}

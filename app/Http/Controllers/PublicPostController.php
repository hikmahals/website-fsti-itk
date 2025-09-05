<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class PublicPostController extends Controller
{
    public function index(Request $request)
    {
        // --- Query Utama untuk Daftar Berita ---
        $query = Post::query()->where('status', 'Terbitkan');

        // Terapkan filter pencarian jika ada
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Terapkan filter kategori jika ada
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $posts = $query->latest('published_at')->paginate(6)->withQueryString();

        // Tambahkan URL gambar untuk daftar berita utama
        $posts->getCollection()->transform(function ($post) {
            if ($post->image_path) {
                $post->image_url = Storage::url($post->image_path);
            }
            return $post;
        });

        // --- Query untuk Sidebar "Berita Terbaru" ---
        $recentPosts = Post::where('status', 'Terbitkan')
            ->latest('published_at')
            ->take(5) // Ambil 5 berita terbaru
            ->get();

        // Tambahkan URL gambar untuk berita terbaru
        $recentPosts->transform(function ($post) {
            if ($post->image_path) {
                $post->image_url = Storage::url($post->image_path);
            }
            return $post;
        });

        // --- Query untuk Filter Kategori ---
        $categories = Post::where('status', 'Terbitkan')
            ->distinct()
            ->pluck('category');

        // PERUBAHAN: Memastikan path ini cocok dengan nama folder Anda 'Berita'
        return Inertia::render('Public/Berita/Index', [
            'posts' => $posts,
            'recentPosts' => $recentPosts,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status !== 'Terbitkan' || is_null($post->published_at)) {
            abort(404);
        }

        if ($post->image_path) {
            $post->image_url = Storage::url($post->image_path);
        }

        // PERUBAHAN: Memastikan path ini cocok dengan nama folder Anda 'Berita'
        return Inertia::render('Public/Berita/Show', [
            'post' => $post,
        ]);
    }
}

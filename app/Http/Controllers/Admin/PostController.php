<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Menampilkan halaman utama daftar berita dengan filter.
     */
    public function index(Request $request) // PERUBAHAN: Menambahkan Request
    {
        // PERUBAHAN: Memulai query builder dan menerapkan filter
        $query = Post::query();

        // Terapkan filter pencarian jika ada
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Terapkan filter status jika ada
        if ($request->has('status') && in_array($request->status, ['Terbitkan', 'Draft'])) {
            $query->where('status', $request->status);
        }

        // Ambil data setelah difilter, urutkan, dan paginasi
        $posts = $query->latest()->paginate(10)->withQueryString();

        // Tambahkan image_url
        $posts->getCollection()->transform(function ($post) {
            if ($post->image_path) {
                $post->image_url = Storage::url($post->image_path);
            }
            return $post;
        });

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
            // PERUBAHAN: Kirim kembali nilai filter ke frontend
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    // ... sisa method (create, store, edit, update, destroy) tidak perlu diubah ...

    public function create()
    {
        return Inertia::render('Admin/Posts/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|in:Prestasi,Liputan Kegiatan,Kerjasama',
            'tags' => 'nullable|string',
            'status' => 'required|in:Draft,Terbitkan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validatedData['image_path'] = $path;
        }

        $validatedData['slug'] = Str::slug($request->title, '-');
        $validatedData['published_at'] = ($request->status === 'Terbitkan') ? now() : null;

        Post::create($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        if ($post->image_path) {
            $post->image_url = Storage::url($post->image_path);
        }

        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id,
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|in:Prestasi,Liputan Kegiatan,Kerjasama',
            'tags' => 'nullable|string',
            'status' => 'required|in:Draft,Terbitkan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validatedData['image_path'] = $path;
        }

        $validatedData['slug'] = Str::slug($request->title, '-');

        if ($request->status === 'Terbitkan' && is_null($post->published_at)) {
            $validatedData['published_at'] = now();
        } elseif ($request->status === 'Draft') {
            $validatedData['published_at'] = null;
        }

        $post->update($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}

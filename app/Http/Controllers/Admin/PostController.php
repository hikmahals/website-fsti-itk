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
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && in_array($request->status, ['Terbitkan', 'Draft'])) {
            $query->where('status', $request->status);
        }

        // Ambil data. 'image_url' akan otomatis ada berkat perbaikan di Model.
        // Tidak perlu lagi blok ->transform() di sini.
        $posts = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return Inertia::render('Admin/Posts/Create');
    }

    /**
     * Menyimpan berita baru ke database.
     */
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

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit(Post $post)
    {
        // PERBAIKAN: Tidak perlu kode apa pun di sini untuk membuat URL.
        // Inertia akan otomatis mendapatkan 'image_url' dari model Post
        // karena sudah ada accessor dan properti $appends di sana.
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post
        ]);
    }

    /**
     * Memperbarui berita di database.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id . ',id',
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

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Post $post)
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}

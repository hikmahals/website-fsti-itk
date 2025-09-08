<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicAchievementController extends Controller
{
    /**
     * Menampilkan halaman utama Prestasi Mahasiswa.
     */
    public function index(Request $request)
    {
        // 1. Ambil 3 Berita terbaru dengan kategori "Prestasi" sebagai sorotan
        $featuredAchievements = Post::where('category', 'Prestasi')
            ->where('status', 'Terbitkan')
            ->latest('published_at')
            ->take(3)
            ->get();

        // 2. Ambil semua data dari tabel 'achievements' untuk tabel daftar prestasi
        $query = Achievement::query();

        // Filter pencarian untuk tabel
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('competition_name', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter berdasarkan tingkat
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $achievements = $query->latest()->paginate(10)->withQueryString();

        // Ambil daftar tahun dan tingkat unik untuk filter dropdown
        $years = Achievement::distinct()->orderBy('year', 'desc')->pluck('year');
        $levels = Achievement::distinct()->pluck('level');

        // PERBAIKAN: Menyesuaikan path agar cocok dengan nama folder 'Prestasi' Anda
        return Inertia::render('Public/Prestasi/Index', [
            'featuredAchievements' => $featuredAchievements,
            'achievements' => $achievements,
            'filters' => $request->only(['search', 'year', 'level']),
            'years' => $years,
            'levels' => $levels,
        ]);
    }
}

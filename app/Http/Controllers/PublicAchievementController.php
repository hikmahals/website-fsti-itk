<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class PublicAchievementController extends Controller
{
    /**
     * Menampilkan halaman galeri prestasi publik dengan statistik dan filter lengkap.
     * Versi ini tidak lagi mengambil berita sorotan.
     */
    public function index(Request $request)
    {
        // 1. Hitung Statistik Lengkap
        $stats = [
            'total_all_time' => Achievement::count(),
            'international' => Achievement::where('level', 'Internasional')->count(),
            'national' => Achievement::where('level', 'Nasional')->count(),
            'academic' => Achievement::where('category', 'Akademik')->count(),
            'non_academic' => Achievement::where('category', 'Non-Akademik')->count(),
        ];

        // 2. Logika Query untuk Galeri dengan Filter Lengkap
        $query = Achievement::query();

        // Filter: Pencarian (Nama Mahasiswa atau Lomba)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('achievement_name', 'like', "%{$search}%");
            });
        }

        // Filter: Tahun
        if ($request->filled('year')) {
            // INI BAGIAN YANG DIPERBAIKI
            $query->where('year', $request->year);
        }

        // Filter: Tingkat
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Filter: Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Ambil data prestasi dengan paginasi
        $achievements = $query->latest()->paginate(9)->withQueryString();

        // 3. Ambil Opsi Unik untuk Dropdown Filter
        $years = Achievement::distinct()->orderBy('year', 'desc')->pluck('year');
        $levels = Achievement::distinct()->pluck('level');
        $categories = Achievement::distinct()->pluck('category');

        // 4. Render Halaman dengan Semua Data yang Diperlukan
        return Inertia::render('Public/Prestasi/Index', [
            'achievements' => $achievements,
            'stats' => $stats,
            'filters' => $request->only(['search', 'year', 'level', 'category']),
            'years' => $years,
            'levels' => $levels,
            'categories' => $categories,
        ]);
    }
}

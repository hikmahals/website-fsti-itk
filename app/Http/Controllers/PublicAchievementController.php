<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB; // Import DB Facade

class PublicAchievementController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil 3 Berita terbaru dengan kategori "Prestasi" sebagai sorotan
        $featuredAchievements = Post::where('category', 'Prestasi')
            ->where('status', 'Terbitkan')
            ->whereNotNull('published_at') // Pastikan tanggal publikasi ada
            ->where('published_at', '!=', '0000-00-00 00:00:00') // Hindari tanggal tidak valid
            ->latest('published_at')
            ->take(3)
            ->get();

        // --- PERUBAHAN BARU: HITUNG STATISTIK ---
        $currentYear = date('Y');
        $stats = [
            'total_this_year' => Achievement::where('year', $currentYear)->count(),
            'international' => Achievement::where('level', 'Internasional')->count(),
            'national' => Achievement::where('level', 'Nasional')->count(),
        ];
        
        // 2. Ambil data prestasi untuk galeri dengan filter
        $query = Achievement::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('competition_name', 'like', "%{$search}%");
            });
        }
        // Filter tahun
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        // Filter tingkat
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $achievements = $query->latest()->paginate(9)->withQueryString();
        
        // --- PERUBAHAN BARU: TAMBAHKAN FOTO DUMMY ---
        // NOTE: Ini hanya untuk demo. Sebaiknya Anda menambahkan kolom 'photo_url'
        // di tabel 'achievements' dan mengupload foto asli.
        $achievements->getCollection()->transform(function ($achievement) {
            $achievement->photo_url = 'https://placehold.co/600x400/133E87/FFFFFF?text=' . urlencode($achievement->student_name);
            return $achievement;
        });

        // Ambil daftar tahun dan tingkat unik untuk filter
        $years = Achievement::distinct()->orderBy('year', 'desc')->pluck('year');
        $levels = Achievement::distinct()->pluck('level');

        return Inertia::render('Public/Prestasi/Index', [
            'featuredAchievements' => $featuredAchievements,
            'achievements' => $achievements,
            'stats' => $stats, // Kirim statistik ke frontend
            'filters' => $request->only(['search', 'year', 'level']),
            'years' => $years,
            'levels' => $levels,
        ]);
    }
}

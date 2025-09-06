<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request; // <-- Tambahkan import Request
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AchievementsController extends Controller
{
    // =============================================
    // PERBAIKAN UTAMA ADA DI FUNGSI INDEX INI
    // =============================================
    public function index(Request $request)
    {
        // Mulai query dasar
        $query = Achievement::query();

        // Terapkan filter pencarian jika ada
        if ($request->filled('search')) {
            $query->where('student_name', 'like', '%' . $request->search . '%')
                ->orWhere('achievement_name', 'like', '%' . $request->search . '%');
        }

        // Terapkan filter kategori jika ada
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Ambil hasil query dengan paginasi dan urutkan
        $achievements = $query->latest()->paginate(10)->withQueryString();

        // Render halaman dan kirim data yang dibutuhkan
        return Inertia::render('Admin/Achievements/Index', [
            'achievements' => $achievements,
            // KIRIM DATA FILTER KEMBALI KE FRONTEND UNTUK FIX ERROR
            'filters' => $request->only(['search', 'category'])
        ]);
    }

    // Fungsi create, store, edit, update, destroy Anda yang lain tidak perlu diubah
    public function create()
    {
        return Inertia::render('Admin/Achievements/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_nim' => 'required|string|max:255',
            'study_program' => 'required|string',
            'achievement_name' => 'required|string',
            'category' => 'required|in:Akademik,Non-Akademik',
            'level' => 'required|string',
            'organizer' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1990',
            'proof' => 'required|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('achievements', 'public');
            $validatedData['proof_path'] = $path;
        }

        Achievement::create($validatedData);

        return redirect()->route('admin.achievements.index')->with('success', 'Data prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement)
    {
        if ($achievement->proof_path) {
            $achievement->proof_url = Storage::url($achievement->proof_path);
        }

        return Inertia::render('Admin/Achievements/Edit', [
            'achievement' => $achievement
        ]);
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_nim' => 'required|string|max:255',
            'study_program' => 'required|string',
            'achievement_name' => 'required|string',
            'category' => 'required|in:Akademik,Non-Akademik',
            'level' => 'required|string',
            'organizer' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1990',
            'proof' => 'required|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            if ($achievement->proof_path) {
                Storage::disk('public')->delete($achievement->proof_path);
            }
            $path = $request->file('proof')->store('achievements', 'public');
            $validatedData['proof_path'] = $path;
        }

        $achievement->update($validatedData);

        return redirect()->route('admin.achievements.index')->with('success', 'Data prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->proof_path) {
            Storage::disk('public')->delete($achievement->proof_path);
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', 'Data prestasi berhasil dihapus.');
    }

    /**
     * Fungsi untuk mengekspor data ke Excel.
     */
    public function export(Request $request)
    {
        // Logika untuk ekspor akan ditambahkan di sini nanti.
        // Untuk sekarang, kita kembalikan pesan sementara.
        return redirect()->back()->with('info', 'Fitur ekspor sedang dalam pengembangan.');
    }

    /**
     * Fungsi untuk mengimpor data dari Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        // Logika untuk impor akan ditambahkan di sini nanti.
        // Untuk sekarang, kita kembalikan pesan sementara.
        return redirect()->back()->with('info', 'Fitur impor sedang dalam pengembangan.');
    }
}

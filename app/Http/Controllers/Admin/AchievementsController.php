<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AchievementsController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query();

        if ($request->filled('search')) {
            $query->where('student_name', 'like', '%' . $request->search . '%')
                ->orWhere('achievement_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $achievements = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Achievements/Index', [
            'achievements' => $achievements,
            'filters' => $request->only(['search', 'category'])
        ]);
    }

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

    /**
     * PERUBAHAN: Fungsi Edit disederhanakan.
     * URL bukti sudah otomatis ditangani oleh accessor di Model.
     */
    public function edit(Achievement $achievement)
    {
        return Inertia::render('Admin/Achievements/Edit', [
            'achievement' => $achievement
        ]);
    }

    /**
     * PERUBAHAN: Fungsi Update disesuaikan.
     * Validasi 'proof' diubah menjadi 'nullable'.
     */
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
            // Bukti sekarang opsional (nullable)
            'proof' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        // Cek jika ada file bukti baru yang diunggah
        if ($request->hasFile('proof')) {
            // Hapus bukti lama jika ada
            if ($achievement->proof_path) {
                Storage::disk('public')->delete($achievement->proof_path);
            }
            // Simpan bukti baru dan perbarui path
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

    public function export(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur ekspor sedang dalam pengembangan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);
        return redirect()->back()->with('info', 'Fitur impor sedang dalam pengembangan.');
    }
}

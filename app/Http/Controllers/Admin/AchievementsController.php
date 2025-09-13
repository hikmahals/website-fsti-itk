<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AchievementsController extends Controller
{
    /**
     * Menampilkan daftar prestasi dengan filter.
     */
    public function index(Request $request)
    {
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

        $achievements = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Achievements/Index', [
            'achievements' => $achievements,
            // PENTING: Selalu kirim 'filters' untuk menghindari error di frontend
            'filters' => $request->only(['search', 'category'])
        ]);
    }

    /**
     * Menampilkan form untuk membuat prestasi baru.
     */
    public function create()
    {
        return Inertia::render('Admin/Achievements/Create');
    }

    /**
     * Menyimpan prestasi baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input: foto wajib, bukti opsional
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_nim' => 'required|string|max:255',
            'study_program' => 'required|string',
            'achievement_name' => 'required|string',
            'category' => 'required|string',
            'level' => 'required|string',
            'organizer' => 'required|string',
            'year' => 'required|digits:4',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan file foto
        if ($request->hasFile('photo')) {
            $validatedData['photo_path'] = $request->file('photo')->store('achievements/photos', 'public');
        }

        // Simpan file bukti jika ada
        if ($request->hasFile('proof')) {
            $validatedData['proof_path'] = $request->file('proof')->store('achievements/proofs', 'public');
        }

        Achievement::create($validatedData);

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit prestasi.
     */
    public function edit(Achievement $achievement)
    {
        return Inertia::render('Admin/Achievements/Edit', [
            'achievement' => $achievement,
        ]);
    }

    /**
     * Memperbarui data prestasi di database.
     */
    public function update(Request $request, Achievement $achievement)
    {
        // Validasi input
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_nim' => 'required|string|max:255',
            'study_program' => 'required|string',
            'achievement_name' => 'required|string',
            'category' => 'required|string',
            'level' => 'required|string',
            'organizer' => 'required|string',
            'year' => 'required|digits:4',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Cek jika ada foto baru yang diunggah
        if ($request->hasFile('photo')) {
            if ($achievement->photo_path) {
                Storage::disk('public')->delete($achievement->photo_path);
            }
            $validatedData['photo_path'] = $request->file('photo')->store('achievements/photos', 'public');
        }

        // Cek jika ada bukti baru yang diunggah
        if ($request->hasFile('proof')) {
            if ($achievement->proof_path) {
                Storage::disk('public')->delete($achievement->proof_path);
            }
            $validatedData['proof_path'] = $request->file('proof')->store('achievements/proofs', 'public');
        }

        $achievement->update($validatedData);

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    /**
     * Menghapus data prestasi dari database.
     */
    public function destroy(Achievement $achievement)
    {
        // Hapus file foto dari storage
        if ($achievement->photo_path) {
            Storage::disk('public')->delete($achievement->photo_path);
        }

        // Hapus file bukti dari storage
        if ($achievement->proof_path) {
            Storage::disk('public')->delete($achievement->proof_path);
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil dihapus.');
    }

    public function export(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur ekspor sedang dalam pengembangan.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        return redirect()->back()->with('info', 'Fitur impor sedang dalam pengembangan.');
    }
}

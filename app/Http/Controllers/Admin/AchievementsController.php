<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement; // <-- Import model Achievement
use Illuminate\Http\Request;
use Inertia\Inertia; // <-- Import Inertia

class AchievementsController extends Controller
{
    /**
     * Menampilkan halaman utama daftar prestasi.
     */
    public function index()
    {
        // Ambil data prestasi dari database, urutkan dari yang terbaru, dan paginasi
        $achievements = Achievement::latest()->paginate(10);

        // Render komponen Vue dan kirim data prestasi sebagai props
        return Inertia::render('Admin/Achievement/Index', [
            'achievements' => $achievements
        ]);
    }

    /**
     * Menampilkan form untuk membuat prestasi baru.
     */
    public function create()
    {
        // Nanti akan merender halaman form tambah prestasi
        // return Inertia::render('Admin/Prestasi/Create');
    }

    /**
     * Menyimpan data prestasi baru ke database.
     */
    public function store(Request $request)
    {
        // Logika validasi dan penyimpanan data akan ditambahkan di sini
    }

    /**
     * Menampilkan detail satu data prestasi.
     */
    public function show(Achievement $achievement)
    {
        //
    }

    /**
     * Menampilkan form untuk mengedit data prestasi.
     */
    public function edit(Achievement $achievement)
    {
        // Nanti akan merender halaman form edit prestasi
        // return Inertia::render('Admin/Prestasi/Edit', [
        //     'achievement' => $achievement
        // ]);
    }

    /**
     * Memperbarui data prestasi di database.
     */
    public function update(Request $request, Achievement $achievement)
    {
        // Logika validasi dan pembaruan data akan ditambahkan di sini
    }

    /**
     * Menghapus data prestasi dari database.
     */
    public function destroy(Achievement $achievement)
    {
        // Logika untuk menghapus data akan ditambahkan di sini
    }
}

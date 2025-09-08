<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
// Hapus 'use Illuminate\Support\Facades\Storage;' karena tidak lagi dibutuhkan

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PERBAIKAN: Hanya hapus record dari tabel database.
        Post::truncate();

        // PERBAIKAN: Hapus baris di bawah ini yang membersihkan direktori storage.
        // Storage::deleteDirectory('public/posts');
        // Storage::makeDirectory('public/posts');

        // Jalankan factory untuk membuat 15 berita baru
        Post::factory(15)->create();
    }
}

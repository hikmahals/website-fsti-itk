<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post; // <-- Jangan lupa import model Post

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat (opsional)
        Post::query()->delete();

        // Menggunakan factory untuk membuat 25 data berita
        Post::factory()->count(25)->create();
    }
}

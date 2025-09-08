<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel posts sebelum diisi
        DB::table('posts')->truncate();

        // Buat 10 data berita palsu menggunakan factory
        Post::factory(10)->create();
    }
}

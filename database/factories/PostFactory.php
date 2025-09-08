<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePathForDatabase = null;
        $directory = 'posts'; // Path relatif di dalam disk 'public'

        // PERBAIKAN: Secara eksplisit gunakan disk 'public' untuk membaca file
        $existingImages = Storage::disk('public')->files($directory);

        // Jika ada gambar di dalam folder storage/app/public/posts, pilih satu
        if (!empty($existingImages)) {
            // $existingImages akan berisi path seperti "posts/berita1.png"
            $randomImage = Arr::random($existingImages);
            // Path ini sudah benar untuk disimpan di database
            $imagePathForDatabase = $randomImage;
        }
        
        $title = $this->faker->sentence(mt_rand(3, 6));
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $this->faker->sentence(mt_rand(10, 15)),
            'content' => $this->faker->paragraphs(mt_rand(5, 10), true),
            'category' => $this->faker->randomElement(['Prestasi', 'Liputan Kegiatan', 'Kerjasama']),
            'tags' => implode(',', $this->faker->words(mt_rand(2, 5))),
            'status' => $this->faker->randomElement(['Draft', 'Terbitkan']),
            'published_at' => now(),
            // Simpan path yang benar
            'image_path' => $imagePathForDatabase,
        ];
    }
}


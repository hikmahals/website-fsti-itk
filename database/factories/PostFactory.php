<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        // Gunakan path tanpa prefix 'public' — karena kita pakai disk('public')
        $imageDirectory = 'posts';

        // Ambil file dari disk public (storage/app/public/posts)
        $files = collect(Storage::disk('public')->files($imageDirectory))
            ->filter(fn($file) => preg_match('/\.(jpg|jpeg|png|gif)$/i', $file))
            ->values()
            ->all();

        // Jika kosong, gunakan fallback (pastikan file default ada di storage/app/public/default/post-placeholder.png)
        if (empty($files)) {
            $files = ['default/post-placeholder.png'];
        }

        // Konten contoh
        $titles = [
            'Mahasiswa FSTI ITK Raih Juara 1 di Kompetisi Gemastik 2025',
            'Seminar Nasional: Tren Kecerdasan Buatan di Era Industri 5.0',
            'Workshop Cybersecurity untuk Mahasiswa: Melindungi Aset Digital',
            'FSTI ITK Buka Program Studi Baru: Sains Data Terapan',
            'Pengabdian Masyarakat oleh Dosen FSTI di Desa Bukit Merdeka',
            'Kunjungan Industri Mahasiswa Informatika ke Kantor Google Indonesia',
        ];

        $title = $this->faker->randomElement($titles);
        $content = '<p>' . implode('</p><p>', $this->faker->paragraphs(rand(5, 10))) . '</p>';
        $publishedDate = $this->faker->dateTimeBetween('-1 year', 'now');

        $categories = ['Prestasi', 'Liputan Kegiatan', 'Kerjasama'];
        $tags = ['ITK', 'FSTI', 'Prestasi', 'Seminar', 'Workshop', 'Sains Data', 'Cybersecurity', 'AI'];
        $statuses = ['Terbitkan', 'Draft'];

        return [
            'title'        => $title,
            'slug' => Str::slug($this->faker->unique()->sentence()) . '-' . Str::random(5),
            'excerpt'      => Str::limit(strip_tags($content), 150),
            'content'      => $content,
            'image_path'   => $this->faker->randomElement($files), // contoh: 'posts/xxx.jpg' atau 'default/post-placeholder.png'
            'category'     => $this->faker->randomElement($categories),
            'tags'         => implode(',', $this->faker->randomElements($tags, rand(1, 3))),
            'status'       => $this->faker->randomElement($statuses),
            'published_at' => $publishedDate,
        ];
    }
}

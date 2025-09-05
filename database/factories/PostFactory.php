<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // PERUBAHAN: Menambahkan daftar judul yang relevan
        $titles = [
            'Mahasiswa FSTI ITK Raih Juara 1 di Kompetisi Robotika Nasional 2025',
            'Workshop Big Data dan AI untuk Industri 4.0 Sukses Digelar di FSTI',
            'FSTI ITK Jalin Kerjasama Strategis dengan Perusahaan Teknologi Terkemuka',
            'Tim Fisika Medis FSTI Publikasikan Jurnal Internasional Terindeks Scopus',
            'Liputan Kegiatan Pengabdian Masyarakat oleh Himpunan Mahasiswa Informatika',
            'Prestasi Gemilang: Mahasiswa FSTI Bawa Pulang Medali Emas dari Olimpiade Sains',
            'Seminar Nasional Mengenai Keamanan Siber di Era Digital',
            'Pengenalan Program Studi Baru: Sains Data di Lingkungan ITK',
        ];

        // PERUBAHAN: Menambahkan daftar tag yang relevan
        $tags = ['Prestasi Mahasiswa', 'Workshop', 'AI', 'Kerjasama Industri', 'Pengabdian Masyarakat', 'Seminar', 'Sains Data', 'Fisika'];

        // Memilih judul acak dari daftar di atas
        $title = $this->faker->randomElement($titles) . ' ' . Str::random(3); // Ditambah string acak agar unik

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(3), // Faker sekarang akan menghasilkan paragraf Bahasa Indonesia
            'content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(12)) . '</p>', // Konten HTML Bahasa Indonesia
            'image_path' => null,
            'category' => $this->faker->randomElement(['Prestasi', 'Liputan Kegiatan', 'Kerjasama']),
            'tags' => $this->faker->randomElement($tags),
            'status' => 'Terbitkan',
            'published_at' => now(),
            'views' => $this->faker->numberBetween(50, 2500),
        ];
    }
}

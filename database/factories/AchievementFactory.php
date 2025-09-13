<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Achievement;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition(): array
    {
        // --- PENAMBAHAN: Logika untuk Foto Mahasiswa (Wajib) ---
        $photoDirectory = 'achievement/photos';
        $photoFiles = Storage::disk('public')->files($photoDirectory);
        // Jika folder foto kosong, berikan nilai null (atau path default jika ada)
        if (empty($photoFiles)) {
            $selectedPhotoPath = null;
        } else {
            $selectedPhotoPath = $this->faker->randomElement($photoFiles);
        }

        // --- PENYESUAIAN: Logika untuk Bukti (Opsional) ---
        // Nama folder diubah sesuai kesepakatan menjadi 'achievements/proofs'
        $proofDirectory = 'achievement/proofs';
        $proofFiles = Storage::disk('public')->files($proofDirectory);

        $selectedProofPath = null; // Defaultnya null (opsional)
        // Jika ada file bukti dan hasil acak true (kemungkinan 50%), baru kita isi path-nya
        if (!empty($proofFiles) && $this->faker->boolean(50)) {
            $selectedProofPath = $this->faker->randomElement($proofFiles);
        }

        // --- BAGIAN LAMA ANDA (TIDAK DIUBAH) ---
        $studyPrograms = [
            'Teknik Elektro',
            'Sistem Informasi',
            'Informatika',
            'Bisnis Digital',
            'Magister Manajemen Teknologi',
            'Fisika',
            'Matematika',
            'Statistika',
            'Ilmu Aktuaria'
        ];

        $achievementNames = [
            'Juara 1 Lomba Competitive Programming Gemastik',
            'Medali Emas Olimpiade Sains Nasional',
            'Best Paper di Konferensi Internasional IEEE',
            'Juara 2 Kompetisi Robotika Nasional',
            'Finalis Pekan Ilmiah Mahasiswa Nasional (PIMNAS)'
        ];

        $levels = ['Internasional', 'Nasional', 'Provinsi', 'Kota/Kabupaten', 'Universitas'];

        $organizers = [
            'Kemendikbudristek',
            'IEEE Organization',
            'Institut Teknologi Bandung',
            'Telkom University',
            'Pemerintah Kota Balikpapan'
        ];

        // --- PENYESUAIAN PADA RETURN ---
        return [
            'student_name'      => $this->faker->name(),
            'student_nim'       => '1101' . $this->faker->unique()->numerify('21####'),
            'study_program'     => $this->faker->randomElement($studyPrograms),
            'achievement_name'  => $this->faker->randomElement($achievementNames),
            'category'          => $this->faker->randomElement(['Akademik', 'Non-Akademik']),
            'level'             => $this->faker->randomElement($levels),
            'organizer'         => $this->faker->randomElement($organizers),
            'year'              => $this->faker->numberBetween(2021, 2025),

            // Kolom photo_path baru, mengambil dari logika di atas (wajib)
            'photo_path'        => $selectedPhotoPath,

            // Kolom proof_path disesuaikan, mengambil dari logika di atas (opsional)
            'proof_path'        => $selectedProofPath,
        ];
    }
}

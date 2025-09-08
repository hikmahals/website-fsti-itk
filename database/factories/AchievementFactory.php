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
        // Folder penyimpanan gambar bukti
        $imageDirectory = 'achievement';

        // Ambil semua file di storage/app/public/achievement
        $files = Storage::disk('public')->files($imageDirectory);

        // Buang prefix "public/" biar sesuai path database
        $imagePaths = array_map(function ($file) {
            return str_replace('public/', '', $file);
        }, $files);

        // Kalau folder kosong → fallback ke default
        if (empty($imagePaths)) {
            // Default proof_path kalau tidak ada gambar
            $imagePaths = ['achievement/default.png'];
        }

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

        return [
            'student_name'      => $this->faker->name(),
            'student_nim'       => '1101' . $this->faker->unique()->numerify('21####'),
            'study_program'     => $this->faker->randomElement($studyPrograms),
            'achievement_name'  => $this->faker->randomElement($achievementNames),
            'category'          => $this->faker->randomElement(['Akademik', 'Non-Akademik']),
            'level'             => $this->faker->randomElement($levels),
            'organizer'         => $this->faker->randomElement($organizers),
            'year'              => $this->faker->numberBetween(2021, 2025),
            'proof_path'        => $this->faker->randomElement($imagePaths),
        ];
    }
}

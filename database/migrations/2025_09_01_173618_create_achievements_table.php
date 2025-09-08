<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id(); // BIGINT, Primary Key, Auto-increment
            $table->string('student_name'); // VARCHAR(255) untuk Nama Mahasiswa
            $table->string('student_nim'); // VARCHAR(255) untuk NIM Mahasiswa

            // ENUM untuk Program Studi
            $table->enum('study_program', [
                'Teknik Elektro',
                'Sistem Informasi',
                'Informatika',
                'Bisnis Digital',
                'Magister Manajemen Teknologi',
                'Fisika',
                'Matematika',
                'Statistika',
                'Ilmu Aktuaria'
            ]);

            $table->text('achievement_name'); // TEXT untuk Capaian Prestasi

            // ENUM untuk Kategori
            $table->enum('category', ['Akademik', 'Non-Akademik']);

            // ENUM untuk Tingkat Prestasi
            $table->enum('level', [
                'Internasional',
                'Nasional',
                'Provinsi',
                'Kota/Kabupaten',
                'Universitas'
            ]);

            $table->string('organizer'); // VARCHAR(255) untuk Penyelenggara
            $table->year('year'); // YEAR untuk Tahun Prestasi
            $table->string('proof_path')->nullable(); // VARCHAR(255) untuk path bukti, boleh kosong
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};

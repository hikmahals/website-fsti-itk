<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Achievement extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_name',
        'student_nim',
        'study_program',
        'achievement_name',
        'category',
        'level',
        'organizer',
        'year',
        'proof_path',
        'photo_path', // PASTIKAN INI ADA
    ];

    /**
     * Menambahkan atribut 'proof_url' dan 'photo_url' secara otomatis.
     *
     * @var array
     */
    protected $appends = ['proof_url', 'photo_url']; // PASTIKAN 'photo_url' ADA

    /**
     * Accessor untuk membuat URL lengkap untuk path bukti.
     *
     * @return string|null
     */
    public function getProofUrlAttribute(): ?string
    {
        if ($this->proof_path) {
            return Storage::url($this->proof_path);
        }
        return null;
    }

    /**
     * Accessor untuk membuat URL lengkap untuk path foto.
     * Jika foto tidak ada, URL placeholder akan digunakan.
     *
     * @return string
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo_path) {
            return Storage::url($this->photo_path);
        }

        // Fallback jika foto (yang seharusnya wajib) ternyata kosong di database
        return 'https://placehold.co/600x400/cccccc/FFFFFF?text=Foto+Tidak+Tersedia';
    }
}

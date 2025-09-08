<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Pastikan ini di-import

class Achievement extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
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
    ];

    /**
     * Menambahkan atribut 'proof_url' secara otomatis ke model.
     *
     * @var array
     */
    protected $appends = ['proof_url'];

    /**
     * Accessor untuk membuat URL lengkap untuk path bukti.
     *
     * @return string|null
     */
    public function getProofUrlAttribute(): ?string
    {
        if ($this->proof_path) {
            // Mengembalikan URL publik untuk file yang disimpan di disk 'public'
            return Storage::url($this->proof_path);
        }
        return null;
    }
}

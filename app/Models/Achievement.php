<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

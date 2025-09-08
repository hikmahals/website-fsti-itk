<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'tags',
        'status',
        'image_path',
        'published_at',
    ];

    protected $appends = ['image_url'];

    /**
     * Accessor untuk image_url
     * * PERBAIKAN FINAL: Gunakan disk 'public' secara eksplisit.
     */
    public function getImageUrlAttribute(): ?string
    {
        // Pastikan image_path tidak kosong dan file-nya ada di disk 'public'
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            // Membuat URL yang benar dari disk 'public'
            return Storage::disk('public')->url($this->image_path);
        }

        // PERBAIKAN: Jika tidak ada gambar, kembalikan null.
        // Jangan gunakan asset() di sini agar konsisten.
        return null;
    }
}

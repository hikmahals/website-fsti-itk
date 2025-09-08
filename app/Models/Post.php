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
    ];

    // otomatis append image_url saat di-convert ke array/JSON
    protected $appends = ['image_url'];

    /**
     * Accessor untuk image_url
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path && Storage::exists('public/' . $this->image_path)) {
            return Storage::url($this->image_path);
        }

        // fallback jika tidak ada gambar
        return asset('default/post-placeholder.png');
    }
}

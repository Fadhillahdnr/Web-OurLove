<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Moment extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_url',
        'image_public_id', // 🔥 baru
        'date'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function booted()
    {
        /* =========================
           AUTO GENERATE SLUG
        ========================= */
        static::creating(function ($moment) {

            if (empty($moment->slug)) {
                $baseSlug = Str::slug($moment->title);
                $slug = $baseSlug;
                $counter = 1;

                while (self::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }

                $moment->slug = $slug;
            }
        });

        /* =========================
           AUTO DELETE CLOUDINARY
        ========================= */
        static::deleting(function ($moment) {

            // Delete thumbnail
            if ($moment->image_public_id) {
                Cloudinary::destroy($moment->image_public_id);
            }

            // Delete all media
            foreach ($moment->media as $media) {
                $media->delete();
            }
        });
    }

    /* =========================
       RELATIONSHIP
    ========================= */
    public function media()
    {
        return $this->hasMany(MomentMedia::class);
    }

}
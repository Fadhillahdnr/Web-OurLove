<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MomentMedia extends Model
{
    protected $fillable = [
        'moment_id',
        'public_id',
        'secure_url',
        'resource_type',
        'format',
        'bytes',
    ];

    public function moment()
    {
        return $this->belongsTo(Moment::class);
    }

    /**
     * AUTO DELETE FILE DI CLOUDINARY SAAT DATA DIHAPUS
     */
    protected static function booted()
    {
        static::deleting(function ($media) {
            if ($media->public_id) {
                Cloudinary::destroy($media->public_id, [
                    'resource_type' => $media->resource_type ?? 'image'
                ]);
            }
        });
    }
}
<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    protected static function booted(): void
    {
        static::deleted(function (Gallery $gallery): void {
            app(ImageUploadService::class)->delete(
                $gallery->image,
            );
        });
    }
}

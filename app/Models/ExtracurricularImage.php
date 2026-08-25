<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtracurricularImage extends Model
{
    protected $fillable = [
        'extracurricular_id',
        'image',
        'alt_text',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::updated(
            function (
                ExtracurricularImage $extracurricularImage,
            ): void {
                if (! $extracurricularImage->wasChanged('image')) {
                    return;
                }

                $previous = $extracurricularImage->getPrevious();
                $oldPath = $previous['image'] ?? null;

                if (
                    filled($oldPath)
                    && $oldPath !== $extracurricularImage->image
                ) {
                    app(ImageUploadService::class)->delete(
                        $oldPath,
                    );
                }
            },
        );

        static::deleted(
            function (
                ExtracurricularImage $extracurricularImage,
            ): void {
                app(ImageUploadService::class)->delete(
                    $extracurricularImage->image,
                );
            },
        );
    }

    public function extracurricular(): BelongsTo
    {
        return $this->belongsTo(Extracurricular::class);
    }
}
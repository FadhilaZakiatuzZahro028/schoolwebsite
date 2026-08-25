<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityImage extends Model
{
    protected $fillable = [
        'facility_id',
        'image',
        'alt_text',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::updated(function (FacilityImage $facilityImage): void {
            if (! $facilityImage->wasChanged('image')) {
                return;
            }

            $previous = $facilityImage->getPrevious();
            $oldPath = $previous['image'] ?? null;

            if (
                filled($oldPath)
                && $oldPath !== $facilityImage->image
            ) {
                app(ImageUploadService::class)->delete(
                    $oldPath,
                );
            }
        });

        static::deleted(function (FacilityImage $facilityImage): void {
            app(ImageUploadService::class)->delete(
                $facilityImage->image,
            );
        });
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}
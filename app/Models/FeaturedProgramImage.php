<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedProgramImage extends Model
{
    protected $fillable = [
        'featured_program_id',
        'image',
        'alt_text',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::updated(
            function (
                FeaturedProgramImage $featuredProgramImage,
            ): void {
                if (! $featuredProgramImage->wasChanged('image')) {
                    return;
                }

                $previous = $featuredProgramImage->getPrevious();
                $oldPath = $previous['image'] ?? null;

                if (
                    filled($oldPath)
                    && $oldPath !== $featuredProgramImage->image
                ) {
                    app(ImageUploadService::class)->delete(
                        $oldPath,
                    );
                }
            },
        );

        static::deleted(
            function (
                FeaturedProgramImage $featuredProgramImage,
            ): void {
                app(ImageUploadService::class)->delete(
                    $featuredProgramImage->image,
                );
            },
        );
    }

    public function featuredProgram(): BelongsTo
    {
        return $this->belongsTo(
            FeaturedProgram::class,
        );
    }

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }
}
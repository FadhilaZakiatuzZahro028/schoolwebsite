<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturedProgram extends Model
{
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected array $featuredProgramImagePathsPendingDeletion = [];

    protected $fillable = [
    'name',
    'slug',
    'summary',
    'description',
    'image',
    'is_active',
    'sort_order',
];

    protected static function booted(): void
    {
        static::forceDeleting(
            function (FeaturedProgram $featuredProgram): void {
                $featuredProgram
                    ->featuredProgramImagePathsPendingDeletion = $featuredProgram
                        ->images()
                        ->pluck('image')
                        ->filter()
                        ->values()
                        ->all();
            },
        );

        static::forceDeleted(
            function (FeaturedProgram $featuredProgram): void {
                $imageUploadService = app(
                    ImageUploadService::class,
                );

                $imageUploadService->delete(
                    $featuredProgram->image,
                );

                foreach (
                    $featuredProgram->featuredProgramImagePathsPendingDeletion
                    as $path
                ) {
                    $imageUploadService->delete($path);
                }

                $featuredProgram
                    ->featuredProgramImagePathsPendingDeletion = [];
            },
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(
            FeaturedProgramImage::class,
        )->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function getRouteKeyName(): string
{
    return 'slug';
}

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
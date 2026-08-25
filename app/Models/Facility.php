<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected array $facilityImagePathsPendingDeletion = [];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    protected static function booted(): void
    {
        static::forceDeleting(function (Facility $facility): void {
            $facility->facilityImagePathsPendingDeletion = $facility
                ->images()
                ->pluck('image')
                ->filter()
                ->values()
                ->all();
        });

        static::forceDeleted(function (Facility $facility): void {
            $imageUploadService = app(
                ImageUploadService::class,
            );

            $imageUploadService->delete(
                $facility->image,
            );

            foreach (
                $facility->facilityImagePathsPendingDeletion
                as $path
            ) {
                $imageUploadService->delete($path);
            }

            $facility->facilityImagePathsPendingDeletion = [];
        });
    }

    public function scopeSearch(
        Builder $query,
        ?string $keyword,
    ): Builder {
        return $query->when(
            $keyword,
            function (
                Builder $query,
                string $keyword,
            ): Builder {
                return $query->where(
                    function (
                        Builder $query,
                    ) use ($keyword): void {
                        $query
                            ->where(
                                'name',
                                'like',
                                "%{$keyword}%",
                            )
                            ->orWhere(
                                'description',
                                'like',
                                "%{$keyword}%",
                            );
                    },
                );
            },
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(FacilityImage::class)
            ->orderBy('sort_order');
    }
}
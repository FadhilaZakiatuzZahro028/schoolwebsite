<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extracurricular extends Model
{
    use SoftDeletes;

    /**
 * @var array<int, string>
 */
protected array $extracurricularImagePathsPendingDeletion = [];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'coach_name',
        'schedule',
        'image',
    ];

    protected static function booted(): void
{
    static::forceDeleting(
        function (Extracurricular $extracurricular): void {
            $extracurricular
                ->extracurricularImagePathsPendingDeletion = $extracurricular
                    ->images()
                    ->pluck('image')
                    ->filter()
                    ->values()
                    ->all();
        },
    );

    static::forceDeleted(
        function (Extracurricular $extracurricular): void {
            $imageUploadService = app(
                ImageUploadService::class,
            );

            $imageUploadService->delete(
                $extracurricular->image,
            );

            foreach (
                $extracurricular
                    ->extracurricularImagePathsPendingDeletion
                as $path
            ) {
                $imageUploadService->delete($path);
            }

            $extracurricular
                ->extracurricularImagePathsPendingDeletion = [];
        },
    );
}

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, function (Builder $query, string $keyword): Builder {
            return $query->where(function (Builder $query) use ($keyword): void {
                $query
                    ->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('coach_name', 'like', "%{$keyword}%")
                    ->orWhere('schedule', 'like', "%{$keyword}%");
            });
        });
    }

    public function images(): HasMany
{
    return $this->hasMany(ExtracurricularImage::class)
        ->orderBy('sort_order');
}
}

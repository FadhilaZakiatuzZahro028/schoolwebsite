<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class AlumniHighlight extends Model
{
    public const MAX_ACTIVE = 4;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'graduation_year',
        'photo',
        'current_activity',
        'institution',
        'quote',
        'is_active',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::saving(function (AlumniHighlight $alumniHighlight): void {
            if (! $alumniHighlight->is_active) {
                return;
            }

            static::ensureActiveSlotAvailable(
                ignoredId: $alumniHighlight->exists
                    ? (int) $alumniHighlight->getKey()
                    : null,
            );
        });

        static::deleted(function (AlumniHighlight $alumniHighlight): void {
            if (blank($alumniHighlight->photo)) {
                return;
            }

            app(ImageUploadService::class)->delete(
                $alumniHighlight->photo,
            );
        });
    }

    public static function ensureActiveSlotAvailable(
        ?int $ignoredId = null,
    ): void {
        $activeAlumniQuery = static::query()->active();

        if ($ignoredId !== null) {
            $activeAlumniQuery->whereKeyNot($ignoredId);
        }

        if ($activeAlumniQuery->count() < self::MAX_ACTIVE) {
            return;
        }

        throw ValidationException::withMessages([
            'is_active' => 'Maksimal 4 alumni pilihan dapat diaktifkan. Nonaktifkan salah satu alumni aktif terlebih dahulu.',
        ]);
    }

    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
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
}

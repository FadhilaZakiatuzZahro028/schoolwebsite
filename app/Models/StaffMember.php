<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    public const TYPE_TEACHER = 'teacher';

    public const TYPE_EMPLOYEE = 'employee';

    protected $fillable = [
        'name',
        'staff_type',
        'photo',
        'position',
        'subject',
        'department',
        'is_active',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleted(function (StaffMember $staffMember): void {
            if (blank($staffMember->photo)) {
                return;
            }

            app(ImageUploadService::class)->delete(
                $staffMember->photo,
            );
        });
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeTeachers(Builder $query): Builder
    {
        return $query->where(
            'staff_type',
            self::TYPE_TEACHER,
        );
    }

    public function scopeEmployees(Builder $query): Builder
    {
        return $query->where(
            'staff_type',
            self::TYPE_EMPLOYEE,
        );
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}

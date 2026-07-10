<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extracurricular extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'coach_name',
        'schedule',
        'image',
    ];

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
}
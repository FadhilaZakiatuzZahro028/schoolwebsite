<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'level',
        'year',
        'image',
    ];

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, function (Builder $query, string $keyword): Builder {
            return $query->where(function (Builder $query) use ($keyword): void {
                $query
                    ->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('level', 'like', "%{$keyword}%");
            });
        });
    }

    public function scopeLevel(Builder $query, ?string $level): Builder
    {
        return $query->when($level, fn (Builder $query): Builder => $query->where('level', $level));
    }

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }
}
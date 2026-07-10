<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ChatbotKnowledge extends Model
{
    protected $table = 'chatbot_knowledges';

    protected $fillable = [
        'keywords',
        'answer',
        'category',
        'is_active',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $query->when($category, fn (Builder $query): Builder => $query->where('category', $category));
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
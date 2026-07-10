<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'default_meta_keywords',
        'default_og_image',
        'copyright_text',
        'is_maintenance',
    ];

    protected function casts(): array
    {
        return [
            'is_maintenance' => 'boolean',
        ];
    }
}
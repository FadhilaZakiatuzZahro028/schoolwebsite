<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProgramSetting extends Model
{
    protected $fillable = [
        'introduction',
        'collaboration_text',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'school_name',
        'tagline',
        'history',
        'vision',
        'mission',
        'principal_name',
        'principal_message',
        'logo',
        'favicon',
        'ppdb_info',
        'ppdb_brochure',
        'address',
        'phone',
        'email',
        'maps_embed',
        'instagram',
        'facebook',
        'youtube',
    ];
}
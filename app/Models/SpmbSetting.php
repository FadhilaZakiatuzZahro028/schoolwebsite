<?php

namespace App\Models;

use App\Services\SpmbFileService;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class SpmbSetting extends Model
{
    protected $fillable = [
        'description',
        'information_file',
        'information_preview',
        'brochure_file',
        'brochure_preview',
    ];

    protected static function booted(): void
    {
        static::creating(function (): void {
            if (self::query()->exists()) {
                throw new LogicException(
                    'Pengaturan SPMB hanya boleh memiliki satu record.',
                );
            }
        });

        static::deleted(function (SpmbSetting $spmbSetting): void {
            app(SpmbFileService::class)->deleteFiles([
                $spmbSetting->information_file,
                $spmbSetting->information_preview,
                $spmbSetting->brochure_file,
                $spmbSetting->brochure_preview,
            ]);
        });
    }
}

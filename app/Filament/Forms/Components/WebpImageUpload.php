<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;

class WebpImageUpload
{
    public static function make(
        string $name,
        string $label,
        ?string $aspectRatio = null
    ): FileUpload {
        $field = FileUpload::make($name)
            ->label($label)
            ->image()
            ->acceptedFileTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
            ])
            ->maxSize(2048)
            ->disk('public')
            ->visibility('public')
            ->storeFiles(false)
            ->imageEditor()
            ->openable()
            ->downloadable();

        if ($aspectRatio !== null) {
            $field
                ->imageEditorAspectRatioOptions([
                    $aspectRatio,
                ])
                ->imageAspectRatio($aspectRatio)
                ->automaticallyOpenImageEditorForAspectRatio();
        }

        return $field;
    }
}
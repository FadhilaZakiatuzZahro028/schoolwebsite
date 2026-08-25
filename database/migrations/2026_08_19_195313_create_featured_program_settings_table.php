<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'featured_program_settings',
            function (Blueprint $table): void {
                $table->id();

                $table->longText('introduction')
                    ->nullable();

                $table->longText('collaboration_text')
                    ->nullable();

                $table->timestamps();
            },
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'featured_program_settings',
        );
    }
};
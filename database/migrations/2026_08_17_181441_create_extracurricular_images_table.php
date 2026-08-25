<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'extracurricular_images',
            function (Blueprint $table): void {
                $table->id();

                $table->foreignId('extracurricular_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('image');
                $table->string('alt_text')->nullable();
                $table->unsignedInteger('sort_order')->default(0);

                $table->timestamps();

                $table->index([
                    'extracurricular_id',
                    'sort_order',
                ]);
            },
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('extracurricular_images');
    }
};
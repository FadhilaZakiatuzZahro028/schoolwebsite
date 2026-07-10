<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('site_name');
            $table->text('site_description');
            $table->string('default_meta_keywords');
            $table->string('default_og_image')->nullable();
            $table->string('copyright_text');
            $table->boolean('is_maintenance')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
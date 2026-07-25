<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spmb_settings', function (Blueprint $table): void {
            $table->id();
            $table->longText('description')->nullable();
            $table->string('information_file')->nullable();
            $table->string('information_preview')->nullable();
            $table->string('brochure_file')->nullable();
            $table->string('brochure_preview')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spmb_settings');
    }
};

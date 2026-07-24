<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table): void {
            $table->id();
            $table->string('school_name');
            $table->string('tagline');
            $table->text('history');
            $table->text('vision');
            $table->text('mission');
            $table->string('principal_name');
            $table->text('principal_message');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('ppdb_info')->nullable();
            $table->string('ppdb_brochure')->nullable();
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->text('maps_embed')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};

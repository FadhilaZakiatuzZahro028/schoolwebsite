<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumni_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->year('graduation_year');
            $table->string('photo')->nullable();
            $table->string('current_activity')->nullable();
            $table->string('institution')->nullable();
            $table->text('quote')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_highlights');
    }
};

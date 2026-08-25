<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_educations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('staff_member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('education_level');
            $table->string('study_program')->nullable();
            $table->string('institution');
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->index([
                'staff_member_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_educations');
    }
};
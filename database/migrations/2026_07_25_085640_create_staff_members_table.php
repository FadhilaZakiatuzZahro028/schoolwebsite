<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_members', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->enum('staff_type', [
                'teacher',
                'employee',
            ]);
            $table->string('photo')->nullable();
            $table->string('position');
            $table->string('subject')->nullable();
            $table->string('department')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('staff_type');
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_members');
    }
};

<?php

use App\Models\Exercise;
use App\Models\UserProgramDay;
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
        Schema::create('user_program_day_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserProgramDay::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Exercise::class)->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('sets');
            $table->unsignedTinyInteger('reps');
            $table->unsignedTinyInteger('percentage')->nullable();
            $table->unsignedTinyInteger('rpe')->nullable();
            $table->unsignedTinyInteger('duration_minutes')->nullable();
            $table->unsignedTinyInteger('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_program_day_exercises');
    }
};

<?php

use App\Models\Program;
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
        Schema::create('program_days', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Program::class)->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('week_number');
            $table->unsignedTinyInteger('day_number');
            $table->string('name')->nullable();
            $table->timestamps();

            $table->unique([
                'program_id',
                'week_number',
                'day_number',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_days');
    }
};

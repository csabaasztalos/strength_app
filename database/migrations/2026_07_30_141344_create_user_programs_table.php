<?php

use App\Models\Program;
use App\Models\User;
use App\UserProgramStatus;
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
        Schema::create('user_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Program::class)->constrained()->cascadeOnDelete();
            $table->integer('current_week')->default(1);
            $table->integer('current_day')->default(1);
            $table->enum('status', UserProgramStatus::cases())->default(UserProgramStatus::STARTED);
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_programs');
    }
};

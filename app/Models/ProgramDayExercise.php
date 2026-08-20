<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['program_id', 'exercise_id', 'sets', 'reps', 'percentage', 'rpe', 'name', 'duration_minutes', 'position'])]

class ProgramDayExercise extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramDayExerciseFactory> */
    use HasFactory;

    public function exercise(): BelongsTo {
        return $this->BelongsTo(Exercise::class);
    }

    public function programDay(): BelongsTo {
        return $this->BelongsTo(ProgramDay::class);
    }
}

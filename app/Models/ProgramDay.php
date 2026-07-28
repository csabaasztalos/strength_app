<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['program_id', 'week_number', 'day_number', 'name'])]

class ProgramDay extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramDayFactory> */
    use HasFactory;

    public function programDayExercises(): HasMany {
        return $this->HasMany(ProgramDayExercise::class);
    }
}

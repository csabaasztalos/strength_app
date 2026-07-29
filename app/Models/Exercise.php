<?php

namespace App\Models;

use App\ExerciseCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
#[Fillable(['name', 'description', 'category'])]
class Exercise extends Model
{
    /** @use HasFactory<\Database\Factories\ExerciseFactory> */
    use HasFactory;

    public function programDayExercises(): HasMany {
        return $this->HasMany(ProgramDayExercise::class);
    }
    
    protected function casts() :array {
        return [
            'category' => ExerciseCategory::class
        ];
    }

}

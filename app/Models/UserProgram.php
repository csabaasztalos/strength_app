<?php

namespace App\Models;

use App\UserProgramStatus;
use Database\Seeders\UserProgramDaySeeder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'program_id', 'status', 'finished_at'])]

class UserProgram extends Model
{
    /** @use HasFactory<\Database\Factories\UserProgramFactory> */
    use HasFactory;

    protected function casts (): array {
        return [
            'status' => UserProgramStatus::class
        ];
    }

    protected $attributes = [
        'status' => UserProgramStatus::STARTED
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo {
        return $this->belongsTo(Program::class);
    }

    public function userProgramDays(): HasMany {
        return $this->HasMany(UserProgramDay::class);
    }

    public function userProgramExerciseMaxes(): HasMany {
        return $this->HasMany(UserProgramExerciseMaxes::class);
    }
}

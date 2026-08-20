<?php

namespace App\Models;

use App\UserProgramDayStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_program_id', 'program_day_id','notes', 'status'])]

class UserProgramDay extends Model
{
    /** @use HasFactory<\Database\Factories\UserProgramDayFactory> */
    use HasFactory;

    protected function casts (): array {
        return [
            'status' => UserProgramDayStatus::class
        ];
    }

    protected $attributes = [
        'status' => null
    ];

    public function userProgram(): BelongsTo {
        return $this->belongsTo(UserProgram::class);
    }

    public function programDay(): BelongsTo {
        return $this->belongsTo(ProgramDay::class);
    }
}

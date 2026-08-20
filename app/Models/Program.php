<?php

namespace App\Models;

use App\ProgramCategory;
use App\ProgramStatus;
use ArrayObject;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'weeks', 'days_per_week', 'category', 'status', 'image_path'])]

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;

    protected function casts () : array {
        return [
            'status' => ProgramStatus::class,
            'category' => ProgramCategory::class
        ];
    }

    protected $attributes = [
        'status' => ProgramStatus::DRAFT
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function programDays(): HasMany {
        return $this->HasMany(ProgramDay::class);
    }

    public function userProgram(): hasMany {
        return $this->HasMany(UserProgram::class);
    }
}

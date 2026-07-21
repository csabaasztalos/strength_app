<?php

namespace App\Models;

use App\ProgramCategory;
use App\ProgramStatus;
use ArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;

    protected function casts () : array {
        return [
            'status' => ProgramStatus::class
        ];
    }

    protected $attributes = [
        'status' => ProgramStatus::DRAFT,
        'category' => ProgramCategory::OLYMPIC
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /*public function exercises(): HasMany {
        return $this->HasMany(Exercise::class);
    }*/
}

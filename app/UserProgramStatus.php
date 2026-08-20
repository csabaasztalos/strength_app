<?php

namespace App;

enum UserProgramStatus: string
{
    case STARTED = 'started';
    case FINISHED = 'finished';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::STARTED => 'Started',
            self::FINISHED => 'Finished',
            self::CANCELLED => 'Cancelled'
        };
    }
}

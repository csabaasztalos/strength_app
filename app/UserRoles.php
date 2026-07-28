<?php

namespace App;

enum UserRoles: string
{
    case ATHLETE = 'athlete';
    case COACH = 'coach';

    public function label(): string
    {
        return match ($this) {
            self::ATHLETE => 'Athlete',
            self::COACH => 'Coach'
        };
    }
}

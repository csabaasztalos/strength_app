<?php

namespace App;

enum ProgramCategory: string
{
    case OLYMPIC = 'olympic_weightlifting';
    case POWERLIFTING = 'powerlifting';
    case STRENGTH = 'general_strength';
    case CONDITIONING = 'conditioning';
    case CROSSFIT = 'crossfit';
    case REHAB = 'rehab';

    public function label(): string {
        return match($this) {
            self::OLYMPIC => 'Olympic weightlifting',
            self::POWERLIFTING => 'Powerlifting',
            self::STRENGTH => 'General strength',
            self::CONDITIONING => 'Conditioning',
            self::CROSSFIT => 'Crossfit',
            self::REHAB => 'Rehab'
        };
    }
}

<?php

namespace App;

enum ExerciseCategory: string
{
    case OLYMPIC = 'olympic_weightlifting';
    case POWERLIFTING = 'powerlifting';
    case STRENGTH = 'general_strength';
    case ACCESSORY = 'accessory';
    case BODYBUILDING = 'bodybuilding';
    case CONDITIONING = 'conditioning';
    case ENDURANCE = 'endurance';
    case REHAB = 'rehab';
    case OTHER = 'other';

    public function label(): string {
        return match($this) {
            self::OLYMPIC => 'Olympic weightlifting',
            self::POWERLIFTING => 'Powerlifting',
            self::STRENGTH => 'Strength',
            self::ACCESSORY => 'Accessory lift',
            self::BODYBUILDING => 'Bodybuilding',
            self::CONDITIONING => 'Conditioning',
            self::ENDURANCE => 'Endurance',
            self::REHAB => 'Rehab',
            self::OTHER => 'Other'
        };
    }
}

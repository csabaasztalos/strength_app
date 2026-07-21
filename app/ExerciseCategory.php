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

    public function label(): string {
        return match($this) {
            self::OLYMPIC => 'Olympic weightlifting exercise',
            self::POWERLIFTING => 'Powerlifting exercise',
            self::STRENGTH => 'Strength exercise',
            self::ACCESSORY => 'Accessory lift',
            self::BODYBUILDING => 'Bodybuilding exercise',
            self::CONDITIONING => 'Conditioning exercise',
            self::ENDURANCE => 'Endurance exercise',
            self::REHAB => 'Rehab exercise'
        };
    }
}

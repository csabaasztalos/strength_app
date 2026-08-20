<?php
namespace App;

enum UserProgramDayStatus: string {
    case COMPLETED = 'completed';
    case SKIPPED = 'skipped';

    public function label() {
        return match ($this) {
            self::COMPLETED => 'Completed',
            self::SKIPPED => 'Skipped'
        };
    }
}


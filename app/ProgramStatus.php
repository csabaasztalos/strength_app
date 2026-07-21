<?php

namespace App;

enum ProgramStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';

    public function label(): string {
        return match($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active'
        };
    }
}
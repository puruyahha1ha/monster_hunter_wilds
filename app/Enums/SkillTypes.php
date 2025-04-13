<?php

namespace App\Enums;

enum SkillTypes: string
{
    case WEAPON = 'weapon';
    case ARMOR  = 'armor';

    public function label(): string
    {
        return match ($this) {
            self::WEAPON => '武器',
            self::ARMOR => '防具',
        };
    }

    public function asSelectArray(): array
    {
        return [
            self::WEAPON->value => self::WEAPON->label(),
            self::ARMOR->value => self::ARMOR->label(),
        ];
    }
}

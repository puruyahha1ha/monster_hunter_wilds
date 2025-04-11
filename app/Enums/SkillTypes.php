<?php

namespace App\Enums;

enum SkillTypes: string
{
    case WEAPON = 'weapon';
    case ARMOR  = 'armor';
    case SERIES = 'series';
    case GROUP  = 'group';

    public function label(): string
    {
        return match ($this) {
            self::WEAPON => '武器',
            self::ARMOR => '防具',
            self::SERIES => 'シリーズ',
            self::GROUP => 'グループ',
        };
    }

    public function asSelectArray(): array
    {
        return [
            self::WEAPON->value => self::WEAPON->label(),
            self::ARMOR->value => self::ARMOR->label(),
            self::SERIES->value => self::SERIES->label(),
            self::GROUP->value => self::GROUP->label(),
        ];
    }
}

<?php

namespace App\Enums;

enum ElementTypes: string
{
    case NONE      = 'none';
    case FIRE      = 'fire';
    case WATER     = 'water';
    case THUNDER   = 'thunder';
    case ICE       = 'ice';
    case DRAGON    = 'dragon';
    case POISON    = 'poison';
    case PARALYZE  = 'paralyze';
    case SLEEP     = 'sleep';
    case EXPLOSION = 'explosion';

    public function label(): string
    {
        return match ($this) {
            self::NONE      => 'なし',
            self::FIRE      => '火',
            self::WATER     => '水',
            self::THUNDER   => '雷',
            self::ICE       => '氷',
            self::DRAGON    => '龍',
            self::POISON    => '毒',
            self::PARALYZE  => '麻痺',
            self::SLEEP     => '睡眠',
            self::EXPLOSION => '爆破',
        };
    }

    public function asSelectArray(): array
    {
        return [
            self::NONE->value      => self::NONE->label(),
            self::FIRE->value      => self::FIRE->label(),
            self::WATER->value     => self::WATER->label(),
            self::THUNDER->value   => self::THUNDER->label(),
            self::ICE->value       => self::ICE->label(),
            self::DRAGON->value    => self::DRAGON->label(),
            self::POISON->value    => self::POISON->label(),
            self::PARALYZE->value  => self::PARALYZE->label(),
            self::SLEEP->value     => self::SLEEP->label(),
            self::EXPLOSION->value => self::EXPLOSION->label(),
        ];
    }
}

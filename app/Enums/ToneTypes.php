<?php

namespace App\Enums;

enum ToneTypes: string
{
    case RED        = 'red';
    case BLUE       = 'blue';
    case GREEN      = 'green';
    case YELLOW     = 'yellow';
    case WHITE      = 'white';
    case PURPLE     = 'purple';
    case LIGHT_BLUE = 'light_blue';
    case ORANGE     = 'orange';

    public function label(): string
    {
        return match ($this) {
            self::RED        => '赤',
            self::BLUE       => '青',
            self::GREEN      => '緑',
            self::YELLOW     => '黄',
            self::WHITE      => '白',
            self::PURPLE     => '紫',
            self::LIGHT_BLUE => '水色',
            self::ORANGE     => 'オレンジ',
        };
    }

    public function asSelectArray(): array
    {
        return [
            self::RED->value        => self::RED->label(),
            self::BLUE->value       => self::BLUE->label(),
            self::GREEN->value      => self::GREEN->label(),
            self::YELLOW->value     => self::YELLOW->label(),
            self::WHITE->value      => self::WHITE->label(),
            self::PURPLE->value     => self::PURPLE->label(),
            self::LIGHT_BLUE->value => self::LIGHT_BLUE->label(),
            self::ORANGE->value     => self::ORANGE->label(),
        ];
    }

}

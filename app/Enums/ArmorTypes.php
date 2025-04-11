<?php

namespace App\Enums;

enum ArmorTypes: string
{
    case HEAD      = 'head';
    case CHEST     = 'chest';
    case ARM       = 'arm';
    case WAIST     = 'waist';
    case LEG       = 'leg';

    public function label(): string
    {
        return match ($this) {
            self::HEAD      => '頭',
            self::CHEST     => '胴',
            self::ARM       => '腕',
            self::WAIST     => '腰',
            self::LEG       => '脚',
        };
    }

    public function asSelectArray(): array
    {
        return [
            self::HEAD->value      => self::HEAD->label(),
            self::CHEST->value     => self::CHEST->label(),
            self::ARM->value       => self::ARM->label(),
            self::WAIST->value     => self::WAIST->label(),
            self::LEG->value       => self::LEG->label(),
        ];
    }
}

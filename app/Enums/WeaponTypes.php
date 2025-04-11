<?php

namespace App\Enums;

enum WeaponTypes: string
{
    case GREAT_SWORD      = 'great_sword';
    case LONG_SWORD       = 'long_sword';
    case SWORD_AND_SHIELD = 'sword_and_shield';
    case DUAL_BLADES      = 'dual_blades';
    case HAMMER           = 'hammer';
    case HUNTING_HORN     = 'hunting_horn';
    case LANCE            = 'lance';
    case GUNLANCE         = 'gunlance';
    case SWITCH_AXE       = 'switch_axe';
    case CHARGE_BLADE     = 'charge_blade';
    case INSECT_GLAIVE    = 'insect_glaive';
    case LIGHT_BOWGUN     = 'light_bowgun';
    case HEAVY_BOWGUN     = 'heavy_bowgun';
    case BOW              = 'bow';

    public function label(): string
    {
        return match ($this) {
            self::GREAT_SWORD      => '大剣',
            self::LONG_SWORD       => '太刀',
            self::SWORD_AND_SHIELD => '片手剣',
            self::DUAL_BLADES      => '双剣',
            self::HAMMER           => 'ハンマー',
            self::HUNTING_HORN     => '狩猟笛',
            self::LANCE            => 'ランス',
            self::GUNLANCE         => 'ガンランス',
            self::SWITCH_AXE       => 'スラッシュアックス',
            self::CHARGE_BLADE     => 'チャージアックス',
            self::INSECT_GLAIVE    => '操虫棍',
            self::LIGHT_BOWGUN     => 'ライトボウガン',
            self::HEAVY_BOWGUN     => 'ヘビィボウガン',
            self::BOW              => '弓',
        };
    }

    public function asSelectArray(): array
    {
        return [
            self::GREAT_SWORD->value      => self::GREAT_SWORD->label(),
            self::LONG_SWORD->value       => self::LONG_SWORD->label(),
            self::SWORD_AND_SHIELD->value => self::SWORD_AND_SHIELD->label(),
            self::DUAL_BLADES->value      => self::DUAL_BLADES->label(),
            self::HAMMER->value           => self::HAMMER->label(),
            self::HUNTING_HORN->value     => self::HUNTING_HORN->label(),
            self::LANCE->value            => self::LANCE->label(),
            self::GUNLANCE->value         => self::GUNLANCE->label(),
            self::SWITCH_AXE->value       => self::SWITCH_AXE->label(),
            self::CHARGE_BLADE->value     => self::CHARGE_BLADE->label(),
            self::INSECT_GLAIVE->value    => self::INSECT_GLAIVE->label(),
            self::LIGHT_BOWGUN->value     => self::LIGHT_BOWGUN->label(),
            self::HEAVY_BOWGUN->value     => self::HEAVY_BOWGUN->label(),
            self::BOW->value              => self::BOW->label(),
        ];
    }
}

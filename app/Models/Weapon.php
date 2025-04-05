<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_weapon_id',
        'name',
        'weapon_type',
        'rarity',
        'attack',
        'defense',
        'element_type',
        'element_value',
        'slot_1',
        'slot_2',
        'slot_3',
        'image_path',
    ];
    protected $casts = [
        'parent_weapon_id' => 'integer',
        'name' => 'string',
        'weapon_type' => 'string',
        'rarity' => 'integer',
        'attack' => 'integer',
        'defense' => 'integer',
        'element_type' => 'string',
        'element_value' => 'integer',
        'slot_1' => 'integer',
        'slot_2' => 'integer',
        'slot_3' => 'integer',
        'image_path' => 'string',
    ];
    protected $attributes = [
        'parent_weapon_id' => null,
        'name' => '',
        'weapon_type' => '大剣',
        'rarity' => 1,
        'attack' => 0,
        'defense' => 0,
        'element_type' => 'なし',
        'element_value' => 0,
        'slot_1' => 0,
        'slot_2' => 0,
        'slot_3' => 0,
        'image_path' => null,
    ];
    protected $table = 'weapons';
    public static function weaponTypes(): array
    {
        return [
            '大剣',
            '太刀',
            '片手剣',
            '双剣',
            'ハンマー',
            '狩猟笛',
            'ランス',
            'ガンランス',
            'スラッシュアックス',
            'チャージアックス',
            '操虫棍',
            'ライトボウガン',
            'ヘビィボウガン',
            '弓'
        ];
    }


    public static function elementTypes(): array
    {
        return [
            'なし',
            '火',
            '水',
            '雷',
            '氷',
            '龍',
            '毒',
            '麻痺',
            '睡眠',
            '爆破'
        ];
    }

    /**
     * Get the weapon's sharpness information.
     */
    public function sharpness(): HasOne
    {
        return $this->hasOne(Sharpness::class);
    }

    /**
     * Get the parent weapon.
     */
    public function parentWeapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class, 'parent_weapon_id');
    }

    /**
     * Get the child weapons.
     */
    public function childWeapons(): HasMany
    {
        return $this->hasMany(Weapon::class, 'parent_weapon_id');
    }
}

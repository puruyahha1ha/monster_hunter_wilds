<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * この武器の親武器を取得
     */
    public function parentWeapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class, 'parent_weapon_id');
    }

    /**
     * この武器の子武器（強化先）を取得
     */
    public function childWeapons(): HasMany
    {
        return $this->hasMany(Weapon::class, 'parent_weapon_id');
    }

    /**
     * 武器の切れ味データを取得
     */
    public function sharpnesses(): HasMany
    {
        return $this->hasMany(Sharpness::class);
    }

    /**
     * 通常の切れ味を取得
     */
    public function normalSharpness()
    {
        return $this->sharpnesses()->where('is_handicraft', 0)->first();
    }

    /**
     * 匠スキル適用時の切れ味を取得
     */
    public function handicraftSharpness()
    {
        return $this->sharpnesses()->where('is_handicraft', 1)->first();
    }

    /**
     * 武器種別の選択肢を取得
     */
    public static function getWeaponTypes(): array
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

    /**
     * 属性種別の選択肢を取得
     */
    public static function getElementTypes(): array
    {
        return ['なし', '火', '水', '雷', '氷', '龍', '毒', '麻痺', '睡眠', '爆破'];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'weapon_type',
        'rarity',
        'attack',
        'element_type',
        'element_value',
        'affinity',
        'sharpness',
        'slot_1',
        'slot_2',
        'slot_3',
        'special_ability',
        'image_path',
        'parent_weapon_id',
    ];

    /**
     * この武器のアップグレード元を取得
     */
    public function parentWeapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class, 'parent_weapon_id');
    }

    /**
     * この武器からアップグレードできる武器を取得
     */
    public function upgrades(): HasMany
    {
        return $this->hasMany(Weapon::class, 'parent_weapon_id');
    }

    /**
     * この武器の作成に必要な素材を取得
     */
    public function craftingMaterials(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'weapon_crafting_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * この武器を使用している装備構成を取得
     */
    public function builds(): HasMany
    {
        return $this->hasMany(BuildDetail::class, 'weapon_id');
    }
}

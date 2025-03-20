<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'effect',
        'obtain_method',
        'rarity',
        'craftable',
        'image_path',
        'max_carry',
    ];

    /**
     * boolean型のカラムをキャスト
     */
    protected $casts = [
        'craftable' => 'boolean',
    ];

    /**
     * このアイテムをドロップするモンスターを取得
     */
    public function monsters(): BelongsToMany
    {
        return $this->belongsToMany(Monster::class, 'monster_drops')
            ->withPivot('condition', 'part', 'drop_rate')
            ->withTimestamps();
    }

    /**
     * このアイテムを素材として使用する武器を取得
     */
    public function weaponsUsingThis(): BelongsToMany
    {
        return $this->belongsToMany(Weapon::class, 'weapon_crafting_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * このアイテムを素材として使用する防具を取得
     */
    public function armorsUsingThis(): BelongsToMany
    {
        return $this->belongsToMany(Armor::class, 'armor_crafting_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}

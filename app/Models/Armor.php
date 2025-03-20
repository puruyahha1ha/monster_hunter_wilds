<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Armor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'armor_type',
        'series_name',
        'rarity',
        'defense',
        'fire_res',
        'water_res',
        'thunder_res',
        'ice_res',
        'dragon_res',
        'slot_1',
        'slot_2',
        'slot_3',
        'image_path',
    ];

    /**
     * この防具の作成に必要な素材を取得
     */
    public function craftingMaterials(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'armor_crafting_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * この防具に付与されているスキルを取得
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'armor_skills')
            ->withPivot('level')
            ->withTimestamps();
    }

    /**
     * 同じシリーズの防具を取得
     */
    public function series()
    {
        return $this->where('series_name', $this->series_name)
            ->where('id', '!=', $this->id)
            ->get();
    }
}

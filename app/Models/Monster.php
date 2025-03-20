<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Monster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species_type',
        'description',
        'image_path',
    ];

    /**
     * モンスターのドロップアイテムを取得
     */
    public function drops(): HasMany
    {
        return $this->hasMany(MonsterDrop::class);
    }

    /**
     * モンスターの弱点を取得
     */
    public function weaknesses(): HasMany
    {
        return $this->hasMany(MonsterWeakness::class);
    }

    /**
     * モンスターの生息地を取得
     */
    public function habitats(): BelongsToMany
    {
        return $this->belongsToMany(Map::class, 'monster_habitats')
            ->withPivot('preferred_areas', 'notes')
            ->withTimestamps();
    }

    /**
     * このモンスターをターゲットにしている装備構成を取得
     */
    public function targetedByBuilds(): HasMany
    {
        return $this->hasMany(Build::class, 'target_monster');
    }
}
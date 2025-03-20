<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Map extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'environmental_features',
        'image_path',
    ];

    /**
     * このマップのエリアを取得
     */
    public function areas(): HasMany
    {
        return $this->hasMany(MapArea::class);
    }

    /**
     * このマップの資源を取得
     */
    public function resources(): HasMany
    {
        return $this->hasMany(MapResource::class);
    }

    /**
     * このマップに生息するモンスターを取得
     */
    public function monsters(): BelongsToMany
    {
        return $this->belongsToMany(Monster::class, 'monster_habitats')
            ->withPivot('preferred_areas', 'notes')
            ->withTimestamps();
    }
}

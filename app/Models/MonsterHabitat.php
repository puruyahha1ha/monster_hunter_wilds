<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonsterHabitat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monster_id',
        'map_id',
        'preferred_areas',
        'notes',
    ];

    /**
     * Get the monster for this habitat.
     */
    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }

    /**
     * Get the map for this habitat.
     */
    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    /**
     * Get the areas where this monster is commonly found.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function preferredMapAreas()
    {
        if (empty($this->preferred_areas)) {
            return collect();
        }

        $areaIds = explode(',', $this->preferred_areas);
        return MapArea::whereIn('id', $areaIds)->get();
    }
}

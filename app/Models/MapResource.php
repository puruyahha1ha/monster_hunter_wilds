<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MapResource extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'map_id',
        'area_id',
        'resource_type',
        'description',
        'possible_items',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'possible_items' => 'array',
    ];

    /**
     * Get the map that this resource belongs to.
     */
    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    /**
     * Get the area that this resource belongs to.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(MapArea::class, 'area_id');
    }

    /**
     * Get the possible items that can be gathered from this resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function items()
    {
        if (empty($this->possible_items)) {
            return collect();
        }

        return Item::whereIn('id', $this->possible_items)->get();
    }

    /**
     * Get resources by type.
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByType(string $type)
    {
        return self::where('resource_type', $type)->get();
    }

    /**
     * Get resource types available in a specific map.
     *
     * @param int $mapId
     * @return array
     */
    public static function getResourceTypesInMap(int $mapId)
    {
        return self::where('map_id', $mapId)
            ->select('resource_type')
            ->distinct()
            ->pluck('resource_type')
            ->toArray();
    }

    /**
     * Get all resources in a specific map area.
     *
     * @param int $areaId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getInArea(int $areaId)
    {
        return self::where('area_id', $areaId)->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MapArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'map_id',
        'area_number',
        'description',
        'is_camp',
        'is_secret',
    ];

    /**
     * boolean型のカラムをキャスト
     */
    protected $casts = [
        'is_camp' => 'boolean',
        'is_secret' => 'boolean',
    ];

    /**
     * このエリアが属するマップを取得
     */
    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    /**
     * このエリアの資源を取得
     */
    public function resources(): HasMany
    {
        return $this->hasMany(MapResource::class, 'area_id');
    }
}

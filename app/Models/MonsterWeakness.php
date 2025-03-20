<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonsterWeakness extends Model
{
    use HasFactory;

    protected $fillable = [
        'monster_id',
        'part',
        'cut_weakness',
        'blunt_weakness',
        'ammo_weakness',
        'fire_weakness',
        'water_weakness',
        'thunder_weakness',
        'ice_weakness',
        'dragon_weakness',
    ];

    /**
     * この弱点のモンスターを取得
     */
    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonsterDrop extends Model
{
    use HasFactory;

    protected $fillable = [
        'monster_id',
        'item_id',
        'condition',
        'part',
        'drop_rate',
    ];

    /**
     * このドロップのモンスターを取得
     */
    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }

    /**
     * このドロップのアイテムを取得
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}

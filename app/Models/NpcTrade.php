<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NpcTrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'npc_id',
        'receive_item_id',
        'receive_quantity',
        'give_item_id',
        'give_quantity',
        'unlock_conditions',
    ];

    /**
     * この取引を行うNPCを取得
     */
    public function npc(): BelongsTo
    {
        return $this->belongsTo(Npc::class);
    }

    /**
     * この取引で受け取るアイテムを取得
     */
    public function receiveItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'receive_item_id');
    }

    /**
     * この取引で渡すアイテムを取得
     */
    public function giveItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'give_item_id');
    }
}
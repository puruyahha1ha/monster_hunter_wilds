<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArmorCraftingMaterial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'armor_id',
        'item_id',
        'quantity',
    ];

    /**
     * Get the armor that requires this material.
     */
    public function armor(): BelongsTo
    {
        return $this->belongsTo(Armor::class);
    }

    /**
     * Get the item that is used as material.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}

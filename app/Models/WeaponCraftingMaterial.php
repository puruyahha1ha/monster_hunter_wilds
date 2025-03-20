<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeaponCraftingMaterial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weapon_id',
        'item_id',
        'quantity',
    ];

    /**
     * Get the weapon that requires this material.
     */
    public function weapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class);
    }

    /**
     * Get the item that is used as material.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponSlot extends Model
{
    protected $fillable = [
        'weapon_id',
        'size',
        'position',
    ];

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }
}

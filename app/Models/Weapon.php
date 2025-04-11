<?php

namespace App\Models;

use App\Enums\ElementTypes;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $fillable = [
        'name',
        'type',
        'rarity',
        'attack',
        'critical_rate',
        'element',
        'element_attack',
        'defense',
    ];

    protected $casts = [
        'element' => ElementTypes::class,
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'weapon_skill')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function slots()
    {
        return $this->hasMany(WeaponSlot::class);
    }
}

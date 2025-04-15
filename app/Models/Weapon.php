<?php

namespace App\Models;

use App\Enums\ElementTypes;
use App\Enums\WeaponTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'type' => WeaponTypes::class,
        'element' => ElementTypes::class,
    ];

    public function skillLevels()
    {
        return $this->belongsToMany(SkillLevel::class, 'weapon_skill_level');
    }

    public function slots()
    {
        return $this->hasMany(WeaponSlot::class);
    }
}

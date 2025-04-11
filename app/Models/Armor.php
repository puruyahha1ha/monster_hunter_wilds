<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ArmorTypes;

class Armor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'series_id',
        'group_id',
        'name',
        'type',
        'rarity',
        'defense',
        'fire_resistance',
        'water_resistance',
        'thunder_resistance',
        'ice_resistance',
        'dragon_resistance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'series_id' => 'integer',
            'group_id' => 'integer',
            'name' => 'string',
            'type' => ArmorTypes::class,
            'rarity' => 'integer',
            'defense' => 'integer',
            'fire_resistance' => 'integer',
            'water_resistance' => 'integer',
            'thunder_resistance' => 'integer',
            'ice_resistance' => 'integer',
            'dragon_resistance' => 'integer',
        ];
    }

    /**
     * Get the armor slots for the armor.
     */
    public function slots()
    {
        return $this->hasMany(ArmorSlot::class);
    }

    /**
     * Get the series associated with the armor.
     */
    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    /**
     * Get the group associated with the armor.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Get the skills associated with the armor.
     */
    public function skills()
    {
        return $this->hasManyThrough(
            Skill::class,
            SkillLevel::class,
            'id',
            'id',
            'skill_level_id',
            'skill_id'
        );
    }

    /**
     * Get the skill levels associated with the armor.
     */
    public function skillLevels()
    {
        return $this->belongsToMany(SkillLevel::class, 'armor_skill_levels', 'armor_id', 'skill_level_id')
            ->withTimestamps();
    }
}

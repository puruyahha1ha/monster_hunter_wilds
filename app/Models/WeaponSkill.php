<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeaponSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * スキルレベルとの関連
     */
    public function levels(): HasMany
    {
        return $this->hasMany(WeaponSkillLevel::class);
    }

    /**
     * 武器との関連付け
     */
    public function weapons(): BelongsToMany
    {
        return $this->belongsToMany(Weapon::class, 'weapon_weapon_skill')
            ->withPivot('level')
            ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeaponSkillLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_skill_id',
        'level',
        'effect_description',
    ];

    /**
     * スキルとの関連
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(WeaponSkill::class, 'weapon_skill_id');
    }

    /**
     * 効果詳細との関連
     */
    public function effects(): HasMany
    {
        return $this->hasMany(SkillLevelEffect::class, 'weapon_skill_level_id');
    }
}

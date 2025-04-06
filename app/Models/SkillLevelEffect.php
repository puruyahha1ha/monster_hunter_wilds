<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillLevelEffect extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_skill_level_id',
        'effect_status',
        'effect_value',
        'effect_type',
    ];

    /**
     * スキルレベルとの関連
     */
    public function skillLevel(): BelongsTo
    {
        return $this->belongsTo(WeaponSkillLevel::class, 'weapon_skill_level_id');
    }
}

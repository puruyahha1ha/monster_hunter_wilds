<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_level',
        'weapon_compatibility',
    ];

    /**
     * このスキルのレベル別効果を取得
     */
    public function levels(): HasMany
    {
        return $this->hasMany(SkillLevel::class);
    }

    /**
     * このスキルを持つ防具を取得
     */
    public function armors(): BelongsToMany
    {
        return $this->belongsToMany(Armor::class, 'armor_skills')
            ->withPivot('level')
            ->withTimestamps();
    }

    /**
     * このスキルを持つ装飾品を取得
     */
    public function decorations(): BelongsToMany
    {
        return $this->belongsToMany(Decoration::class, 'decoration_skills')
            ->withPivot('level')
            ->withTimestamps();
    }

    /**
     * このスキルを含む装備構成を取得
     */
    public function builds(): BelongsToMany
    {
        return $this->belongsToMany(Build::class, 'build_skills')
            ->withPivot('level')
            ->withTimestamps();
    }
}

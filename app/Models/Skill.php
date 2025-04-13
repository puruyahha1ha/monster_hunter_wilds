<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SkillTypes;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'description',
        'max_level',
        'type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'max_level' => 'integer',
        'type' => SkillTypes::class,
    ];

    /**
     * スキルレベルリレーション
     */
    public function levels()
    {
        return $this->hasMany(SkillLevel::class);
    }
}

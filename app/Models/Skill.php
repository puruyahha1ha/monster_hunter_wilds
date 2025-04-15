<?php

namespace App\Models;

use App\Enums\SkillTypes;
use Illuminate\Database\Eloquent\Model;

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

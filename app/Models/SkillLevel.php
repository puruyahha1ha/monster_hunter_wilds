<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillLevel extends Model
{
    protected $fillable = [
        'skill_id',
        'level',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * スキルリレーション
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}

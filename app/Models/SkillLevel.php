<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_id',
        'level',
        'effect',
    ];

    /**
     * このスキルレベルが属するスキルを取得
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}

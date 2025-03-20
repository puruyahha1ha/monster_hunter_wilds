<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Decoration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rarity',
        'slot_size',
        'obtain_method',
        'image_path',
    ];

    /**
     * この装飾品が付与するスキルを取得
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'decoration_skills')
            ->withPivot('level')
            ->withTimestamps();
    }
}

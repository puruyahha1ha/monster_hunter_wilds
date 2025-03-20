<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Npc extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'location',
        'description',
        'image_path',
    ];

    /**
     * このNPCが提供するクエストを取得
     */
    public function quests(): HasMany
    {
        return $this->hasMany(NpcQuest::class);
    }

    /**
     * このNPCの取引情報を取得
     */
    public function trades(): HasMany
    {
        return $this->hasMany(NpcTrade::class);
    }
}

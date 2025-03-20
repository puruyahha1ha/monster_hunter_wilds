<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NpcQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'npc_id',
        'title',
        'description',
        'difficulty',
        'objectives',
        'rewards',
        'unlock_conditions',
    ];

    /**
     * このクエストを提供するNPCを取得
     */
    public function npc(): BelongsTo
    {
        return $this->belongsTo(Npc::class);
    }
}
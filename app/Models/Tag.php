<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * このタグが付けられた装備構成を取得
     */
    public function builds(): BelongsToMany
    {
        return $this->belongsToMany(Build::class, 'build_tags')
            ->withTimestamps();
    }
}

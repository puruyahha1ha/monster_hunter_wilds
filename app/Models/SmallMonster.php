<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmallMonster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'danger_level',
        'is_aggressive',
    ];

    /**
     * boolean型のカラムをキャスト
     */
    protected $casts = [
        'is_aggressive' => 'boolean',
    ];
}

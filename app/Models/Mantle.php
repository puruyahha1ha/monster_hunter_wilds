<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'effect',
        'activation_condition',
        'duration_seconds',
        'cooldown_seconds',
        'obtain_method',
        'recommended_weapons',
        'recommended_situations',
        'image_path',
    ];
}

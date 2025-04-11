<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'description',
        'max_level',
        'skill_type',
        'critical_rate',
        'element',
        'element_attack',
        'defense',
    ];
}

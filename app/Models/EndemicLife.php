<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndemicLife extends Model
{
    use HasFactory;

    /**
     * テーブル名を明示的に指定
     */
    protected $table = 'endemic_life';

    protected $fillable = [
        'name',
        'effect',
        'capture_method',
        'usage_tips',
        'image_path',
    ];
}
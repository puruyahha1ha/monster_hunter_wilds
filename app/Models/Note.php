<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'color',
        'display',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function huntingHornDetails()
    {
        return $this->hasMany(HuntingHornDetail::class);
    }

    public function weaponMelody()
    {
        return $this->hasMany(WeaponMelody::class);
    }

    public function getColorAttribute($value)
    {
        return match ($value) {
            '赤' => 'red',
            '青' => 'blue',
            '緑' => 'green',
            '黄' => 'yellow',
            '白' => 'white',
            '紫' => 'purple',
            '水色' => 'lightblue',
            'オレンジ' => 'orange',
        };
    }

    public function getDisplayAttribute($value)
    {
        return match ($value) {
            'crotchet' => '四分音符',
            'quaver' => '八分音符',
            'quavers' => '十六分音符',
        };
    }
}

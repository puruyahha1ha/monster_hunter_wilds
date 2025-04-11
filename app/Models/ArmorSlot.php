<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArmorSlot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'armor_id',
        'size',
        'position',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'armor_id' => 'integer',
            'size' => 'integer',
            'position' => 'integer',
        ];
    }

    /**
     * Get the armor that owns the slot.
     */
    public function armor()
    {
        return $this->belongsTo(Armor::class);
    }
}

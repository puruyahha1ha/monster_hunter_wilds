<?php

namespace App\Models;

use App\Enums\DecorationTypes;
use Illuminate\Database\Eloquent\Model;

class Decoration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'size',
        'rarity',
        'type',
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
            'id' => 'integer',
            'name' => 'string',
            'size' => 'integer',
            'rarity' => 'integer',
            'type' => DecorationTypes::class,
        ];
    }

    /**
     * Get the skill levels for the decoration.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skillLevels()
    {
        return $this->hasMany(SkillLevel::class);
    }
}

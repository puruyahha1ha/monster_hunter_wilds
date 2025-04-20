<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Series extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
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
            'description' => 'string',
        ];
    }

    /**
     * Get the skills for the series.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'series_skill', 'series_id', 'skill_id');
    }
}

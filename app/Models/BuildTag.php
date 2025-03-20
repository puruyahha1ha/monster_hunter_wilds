<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildTag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'build_id',
        'tag_id',
    ];

    /**
     * Get the build that owns this tag relationship.
     */
    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }

    /**
     * Get the tag for this relationship.
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
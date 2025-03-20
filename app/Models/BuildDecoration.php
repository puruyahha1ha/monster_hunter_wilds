<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildDecoration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'build_id',
        'decoration_id',
        'equipment_type', // 'weapon', 'head', 'chest', etc.
        'slot_number',    // 1, 2, 3
    ];

    /**
     * Get the build that owns this decoration.
     */
    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }

    /**
     * Get the decoration for this relationship.
     */
    public function decoration(): BelongsTo
    {
        return $this->belongsTo(Decoration::class);
    }

    /**
     * Get the equipment this decoration is slotted into.
     * 
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function equipment()
    {
        $buildDetail = $this->build->detail;

        if (!$buildDetail) {
            return null;
        }

        switch ($this->equipment_type) {
            case 'weapon':
                return $buildDetail->weapon;
            case 'head':
                return $buildDetail->headArmor;
            case 'chest':
                return $buildDetail->chestArmor;
            case 'arms':
                return $buildDetail->armArmor;
            case 'waist':
                return $buildDetail->waistArmor;
            case 'legs':
                return $buildDetail->legArmor;
            default:
                return null;
        }
    }
}

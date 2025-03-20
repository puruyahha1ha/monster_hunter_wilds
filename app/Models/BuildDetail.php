<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'build_id',
        'weapon_id',
        'head_armor_id',
        'chest_armor_id',
        'arm_armor_id',
        'waist_armor_id',
        'leg_armor_id',
        'mantle1_id',
        'mantle2_id',
    ];

    /**
     * この詳細が属する装備構成を取得
     */
    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }

    /**
     * この装備構成の武器を取得
     */
    public function weapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class);
    }

    /**
     * この装備構成の頭防具を取得
     */
    public function headArmor(): BelongsTo
    {
        return $this->belongsTo(Armor::class, 'head_armor_id');
    }

    /**
     * この装備構成の胴防具を取得
     */
    public function chestArmor(): BelongsTo
    {
        return $this->belongsTo(Armor::class, 'chest_armor_id');
    }

    /**
     * この装備構成の腕防具を取得
     */
    public function armArmor(): BelongsTo
    {
        return $this->belongsTo(Armor::class, 'arm_armor_id');
    }

    /**
     * この装備構成の腰防具を取得
     */
    public function waistArmor(): BelongsTo
    {
        return $this->belongsTo(Armor::class, 'waist_armor_id');
    }

    /**
     * この装備構成の脚防具を取得
     */
    public function legArmor(): BelongsTo
    {
        return $this->belongsTo(Armor::class, 'leg_armor_id');
    }

    /**
     * この装備構成の装衣1を取得
     */
    public function mantle1(): BelongsTo
    {
        return $this->belongsTo(Mantle::class, 'mantle1_id');
    }

    /**
     * この装備構成の装衣2を取得
     */
    public function mantle2(): BelongsTo
    {
        return $this->belongsTo(Mantle::class, 'mantle2_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sharpness extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_id',
        'red',
        'orange',
        'yellow',
        'green',
        'blue',
        'white',
        'purple',
        'is_handicraft',
    ];

    /**
     * この切れ味データが属する武器を取得
     */
    public function weapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class);
    }

    /**
     * 合計切れ味ゲージを取得
     */
    public function getTotalSharpness(): int
    {
        return $this->red + $this->orange + $this->yellow + $this->green +
            $this->blue + $this->white + $this->purple;
    }

    /**
     * 各色の切れ味の割合を計算（グラフ表示用）
     */
    public function getSharpnessPercentages(): array
    {
        $total = $this->getTotalSharpness();
        if ($total === 0) {
            return [
                'red' => 0,
                'orange' => 0,
                'yellow' => 0,
                'green' => 0,
                'blue' => 0,
                'white' => 0,
                'purple' => 0,
            ];
        }

        return [
            'red' => round(($this->red / $total) * 100, 1),
            'orange' => round(($this->orange / $total) * 100, 1),
            'yellow' => round(($this->yellow / $total) * 100, 1),
            'green' => round(($this->green / $total) * 100, 1),
            'blue' => round(($this->blue / $total) * 100, 1),
            'white' => round(($this->white / $total) * 100, 1),
            'purple' => round(($this->purple / $total) * 100, 1),
        ];
    }
}

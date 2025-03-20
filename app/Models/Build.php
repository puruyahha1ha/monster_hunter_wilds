<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Build extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'purpose',
        'target_monster',
        'is_public',
        'image_path',
    ];

    /**
     * boolean型のカラムをキャスト
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * この装備構成を作成したユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この装備構成の詳細情報を取得
     */
    public function detail(): HasOne
    {
        return $this->hasOne(BuildDetail::class);
    }

    /**
     * この装備構成に使用されている装飾品を取得
     */
    public function decorations(): BelongsToMany
    {
        return $this->belongsToMany(Decoration::class, 'build_decorations')
            ->withPivot('equipment_type', 'slot_number')
            ->withTimestamps();
    }

    /**
     * この装備構成のスキル情報を取得
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'build_skills')
            ->withPivot('level')
            ->withTimestamps();
    }

    /**
     * この装備構成へのいいねを取得
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * この装備構成へのコメントを取得
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * この装備構成のタグを取得
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'build_tags')
            ->withTimestamps();
    }

    /**
     * この装備構成がターゲットにしているモンスターを取得
     */
    public function targetMonster(): BelongsTo
    {
        return $this->belongsTo(Monster::class, 'target_monster');
    }
}

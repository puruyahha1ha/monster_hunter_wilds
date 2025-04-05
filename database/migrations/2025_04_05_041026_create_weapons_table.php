<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_weapon_id')->nullable()->constrained('weapons')->onDelete('cascade')->comment('親武器ID');
            $table->string('name', 255)->comment('武器名');
            $table->enum('weapon_type', ['大剣', '太刀', '片手剣', '双剣', 'ハンマー', '狩猟笛', 'ランス', 'ガンランス', 'スラッシュアックス', 'チャージアックス', '操虫棍', 'ライトボウガン', 'ヘビィボウガン', '弓'])->default('大剣')->comment('武器種別');
            $table->unsignedTinyInteger('rarity')->default(1)->comment('レアリティ');
            $table->unsignedInteger('attack')->default(0)->comment('攻撃力');
            $table->unsignedInteger('defense')->default(0)->comment('防御力ボーナス');
            $table->enum('element_type', ['なし', '火', '水', '雷', '氷', '龍', '毒', '麻痺', '睡眠', '爆破'])->default('なし')->comment('属性種別');
            $table->unsignedInteger('element_value')->default(0)->comment('属性値');
            $table->unsignedTinyInteger('slot_1')->default(0)->comment('スロット1');
            $table->unsignedTinyInteger('slot_2')->default(0)->comment('スロット2');
            $table->unsignedTinyInteger('slot_3')->default(0)->comment('スロット3');
            $table->string('image_path', 255)->nullable()->comment('画像パス');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};

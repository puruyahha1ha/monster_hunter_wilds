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
            $table->string('name')->comment('武器名');
            $table->string('type')->comment('武器種');
            $table->integer('rarity')->comment('レアリティ');
            $table->integer('attack')->comment('攻撃力');
            $table->integer('critical_rate')->comment('クリティカル率');
            $table->string('element')->comment('属性');
            $table->integer('element_attack')->comment('属性攻撃力');
            $table->integer('defense')->comment('防御力ボーナス');
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

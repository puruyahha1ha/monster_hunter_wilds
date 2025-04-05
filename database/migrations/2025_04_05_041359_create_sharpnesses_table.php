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
        Schema::create('sharpnesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_id')->constrained('weapons')->onDelete('cascade')->comment('武器ID');
            $table->unsignedInteger('red')->default(0)->comment('赤ゲージ');
            $table->unsignedInteger('orange')->default(0)->comment('オレンジゲージ');
            $table->unsignedInteger('yellow')->default(0)->comment('黄ゲージ');
            $table->unsignedInteger('green')->default(0)->comment('緑ゲージ');
            $table->unsignedInteger('blue')->default(0)->comment('青ゲージ');
            $table->unsignedInteger('white')->default(0)->comment('白ゲージ');
            $table->unsignedInteger('purple')->default(0)->comment('紫ゲージ');
            $table->unsignedTinyInteger('is_handicraft')->default(0)->comment('匠スキルの有無');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sharpnesses');
    }
};

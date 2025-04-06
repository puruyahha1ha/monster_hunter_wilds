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
        Schema::create('weapon_skill_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_skill_id')->constrained('weapon_skills')->onDelete('cascade')->comment('スキルID');
            $table->unsignedTinyInteger('level')->default(1)->comment('スキルレベル');
            $table->text('effect_description')->comment('効果説明');
            $table->timestamps();

            $table->unique(['weapon_skill_id', 'level']);
        });

        Schema::create('skill_level_effects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_skill_level_id')->constrained('weapon_skill_levels')->onDelete('cascade')->comment('スキルレベルID');
            $table->enum('effect_status', ['attack', 'defense', 'sharpness'])->default('attack')->comment('適応ステータス');
            $table->decimal('effect_value', 8, 2)->default(0)->comment('効果値');
            $table->enum('effect_type', ['none', 'add', 'multiply'])->default('none')->comment('効果タイプ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_level_effects');
        Schema::dropIfExists('weapon_skill_levels');
    }
};

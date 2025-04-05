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
            $table->text('effecf_description')->comment('効果説明');
            $table->enum('effect_status', ['attack', 'defense', 'sharpness'])->default('attack')->comment('適応ステータス');
            $table->unsignedInteger('effect_value')->default(0)->comment('効果値');
            $table->enum('effect_type', ['none', 'add', 'multiply'])->default('none')->comment('効果タイプ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapon_skill_levels');
    }
};

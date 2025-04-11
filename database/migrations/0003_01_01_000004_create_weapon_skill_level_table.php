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
        Schema::create('weapon_skill_level', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_id')->constrained('weapons')->onDelete('cascade')->comment('武器ID');
            $table->foreignId('skill_level_id')->constrained('skill_levels')->onDelete('cascade')->comment('スキルレベルID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weapon_skill_level', function (Blueprint $table) {
            $table->dropForeign(['weapon_id']);
            $table->dropForeign(['skill_level_id']);
        });
        Schema::dropIfExists('weapon_skill_level');
    }
};

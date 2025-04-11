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
        Schema::create('armor_skill_level', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armor_id')->constrained('armors')->onDelete('cascade')->comment('防具ID');
            $table->foreignId('skill_level_id')->constrained('skill_levels')->onDelete('cascade')->comment('スキルレベルID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('armor_skill_level', function (Blueprint $table) {
            $table->dropForeign(['armor_id']);
            $table->dropForeign(['skill_level_id']);
        });
        Schema::dropIfExists('armor_skill_level');
    }
};

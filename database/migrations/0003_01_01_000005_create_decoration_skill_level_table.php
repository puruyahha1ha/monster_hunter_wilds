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
        Schema::create('decoration_skill_level', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decoration_id')->constrained('decorations')->onDelete('cascade')->comment('装飾品ID');
            $table->foreignId('skill_level_id')->constrained('skill_levels')->onDelete('cascade')->comment('スキルレベルID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decoration_skill_level', function (Blueprint $table) {
            $table->dropForeign(['decoration_id']);
            $table->dropForeign(['skill_level_id']);
        });
        Schema::dropIfExists('decoration_skill_level');
    }
};

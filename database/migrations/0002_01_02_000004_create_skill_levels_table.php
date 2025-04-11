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
        Schema::create('skill_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade')->comment('スキルID');
            $table->integer('level')->comment('スキルレベル');
            $table->string('description')->comment('スキル説明');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skill_levels', function (Blueprint $table) {
            $table->dropForeign(['skill_id']);
        });
        Schema::dropIfExists('skill_levels');
    }
};

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
        Schema::create('weapon_weapon_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_id')->constrained('weapons')->onDelete('cascade')->comment('武器ID');
            $table->foreignId('weapon_skill_id')->constrained('weapon_skills')->onDelete('cascade')->comment('スキルID');
            $table->unsignedTinyInteger('level')->default(1)->comment('スキルレベル');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapon_weapon_skill');
    }
};

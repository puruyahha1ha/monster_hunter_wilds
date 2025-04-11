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
        Schema::create('series_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained('series')->onDelete('cascade')->comment('シリーズID');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade')->comment('スキルID');
            $table->integer('required_parts')->comment('必要部位数：2または4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('series_skill', function (Blueprint $table) {
            $table->dropForeign(['series_id']);
            $table->dropForeign(['skill_id']);
        });
        Schema::dropIfExists('series_skill');
    }
};

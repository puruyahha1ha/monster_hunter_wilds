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
        Schema::create('group_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade')->comment('グループID');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade')->comment('スキルID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_skill', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['skill_id']);
        });
        Schema::dropIfExists('group_skill');
    }
};

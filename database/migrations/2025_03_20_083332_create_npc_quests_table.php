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
        Schema::create('npc_quests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('npc_id');
            $table->string('title');
            $table->text('description');
            $table->enum('rank', ['下位', '上位', 'マスター'])->default('下位');
            $table->text('objectives');
            $table->text('rewards')->nullable();
            $table->text('unlock_conditions')->nullable();
            $table->timestamps();

            $table->foreign('npc_id')->references('id')->on('npcs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npc_quests');
    }
};

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
        Schema::create('npc_trades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('npc_id');
            $table->unsignedBigInteger('receive_item_id');
            $table->unsignedInteger('receive_quantity')->default(1);
            $table->unsignedBigInteger('give_item_id');
            $table->unsignedInteger('give_quantity')->default(1);
            $table->text('unlock_conditions')->nullable();
            $table->timestamps();

            $table->foreign('npc_id')->references('id')->on('npcs')->onDelete('cascade');
            $table->foreign('receive_item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('give_item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npc_trades');
    }
};

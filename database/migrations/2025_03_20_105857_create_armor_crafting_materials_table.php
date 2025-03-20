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
        Schema::create('armor_crafting_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('armor_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedInteger('quantity');
            $table->timestamps();
            
            $table->foreign('armor_id')->references('id')->on('armors')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armor_crafting_materials');
    }
};

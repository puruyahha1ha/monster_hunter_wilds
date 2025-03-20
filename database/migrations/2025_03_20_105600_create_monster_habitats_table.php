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
        Schema::create('monster_habitats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('monster_id');
            $table->unsignedBigInteger('map_id');
            $table->text('preferred_areas')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('monster_id')->references('id')->on('monsters')->onDelete('cascade');
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
            
            $table->unique(['monster_id', 'map_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monster_habitats');
    }
};

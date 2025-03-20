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
        Schema::create('map_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('map_id');
            $table->unsignedBigInteger('area_id');
            $table->string('resource_type'); // mining, bonepile, plant, etc.
            $table->text('description');
            $table->json('possible_items'); // JSON array of item_ids
            $table->timestamps();
            
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('map_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_resources');
    }
};

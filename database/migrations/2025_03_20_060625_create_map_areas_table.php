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
        Schema::create('map_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('map_id');
            $table->unsignedTinyInteger('area_number');
            $table->text('description');
            $table->boolean('is_camp')->default(false);
            $table->boolean('is_secret')->default(false);
            $table->timestamps();
            
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
            
            $table->unique(['map_id', 'area_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_areas');
    }
};

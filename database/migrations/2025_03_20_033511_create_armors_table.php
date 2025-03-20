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
        Schema::create('armors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('armor_type', ['head', 'chest', 'arms', 'waist', 'legs']);
            $table->string('series_name');
            $table->unsignedTinyInteger('rarity');
            $table->unsignedInteger('defense');
            $table->integer('fire_res');
            $table->integer('water_res');
            $table->integer('thunder_res');
            $table->integer('ice_res');
            $table->integer('dragon_res');
            $table->string('slot_1')->nullable();
            $table->string('slot_2')->nullable();
            $table->string('slot_3')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armors');
    }
};

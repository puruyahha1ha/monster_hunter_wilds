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
        Schema::create('monster_weaknesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('monster_id');
            $table->string('part');
            $table->unsignedTinyInteger('cut_weakness');
            $table->unsignedTinyInteger('blunt_weakness');
            $table->unsignedTinyInteger('ammo_weakness');
            $table->unsignedTinyInteger('fire_weakness');
            $table->unsignedTinyInteger('water_weakness');
            $table->unsignedTinyInteger('thunder_weakness');
            $table->unsignedTinyInteger('ice_weakness');
            $table->unsignedTinyInteger('dragon_weakness');
            $table->timestamps();
            
            $table->foreign('monster_id')->references('id')->on('monsters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monster_weaknesses');
    }
};

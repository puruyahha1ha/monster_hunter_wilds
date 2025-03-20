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
        Schema::create('build_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('build_id');
            $table->unsignedBigInteger('weapon_id')->nullable();
            $table->unsignedBigInteger('sub_weapon_id')->nullable();
            $table->unsignedBigInteger('head_armor_id')->nullable();
            $table->unsignedBigInteger('chest_armor_id')->nullable();
            $table->unsignedBigInteger('arm_armor_id')->nullable();
            $table->unsignedBigInteger('waist_armor_id')->nullable();
            $table->unsignedBigInteger('leg_armor_id')->nullable();
            $table->unsignedBigInteger('mantle1_id')->nullable();
            $table->unsignedBigInteger('mantle2_id')->nullable();
            $table->timestamps();
            
            $table->foreign('build_id')->references('id')->on('builds')->onDelete('cascade');
            $table->foreign('weapon_id')->references('id')->on('weapons')->onDelete('set null');
            $table->foreign('sub_weapon_id')->references('id')->on('weapons')->onDelete('set null');
            $table->foreign('head_armor_id')->references('id')->on('armors')->onDelete('set null');
            $table->foreign('chest_armor_id')->references('id')->on('armors')->onDelete('set null');
            $table->foreign('arm_armor_id')->references('id')->on('armors')->onDelete('set null');
            $table->foreign('waist_armor_id')->references('id')->on('armors')->onDelete('set null');
            $table->foreign('leg_armor_id')->references('id')->on('armors')->onDelete('set null');
            $table->foreign('mantle1_id')->references('id')->on('mantles')->onDelete('set null');
            $table->foreign('mantle2_id')->references('id')->on('mantles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_details');
    }
};

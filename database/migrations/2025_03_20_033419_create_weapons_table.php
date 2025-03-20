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
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('weapon_type');
            $table->unsignedTinyInteger('rarity');
            $table->unsignedInteger('attack');
            $table->string('element_type')->nullable();
            $table->unsignedInteger('element_value')->nullable();
            $table->integer('affinity')->default(0);
            $table->string('sharpness')->nullable();
            $table->string('slot_1')->nullable();
            $table->string('slot_2')->nullable();
            $table->string('slot_3')->nullable();
            $table->text('special_ability')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('parent_weapon_id')->nullable();
            $table->timestamps();
            
            $table->foreign('parent_weapon_id')->references('id')->on('weapons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};

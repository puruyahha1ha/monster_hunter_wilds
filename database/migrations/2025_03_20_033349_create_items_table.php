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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->text('effect');
            $table->text('obtain_method')->nullable();
            $table->string('rarity')->nullable();
            $table->boolean('craftable')->default(false);
            $table->string('image_path')->nullable();
            $table->unsignedTinyInteger('max_carry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

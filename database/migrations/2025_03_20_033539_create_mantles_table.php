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
        Schema::create('mantles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('effect');
            $table->text('activation_condition')->nullable();
            $table->unsignedInteger('duration_seconds');
            $table->unsignedInteger('cooldown_seconds');
            $table->text('obtain_method');
            $table->text('recommended_weapons')->nullable();
            $table->text('recommended_situations')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantles');
    }
};

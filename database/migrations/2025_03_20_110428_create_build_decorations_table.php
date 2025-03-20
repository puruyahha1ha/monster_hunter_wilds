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
        Schema::create('build_decorations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('build_id');
            $table->unsignedBigInteger('decoration_id');
            $table->string('equipment_type');
            $table->unsignedTinyInteger('slot_number');
            $table->timestamps();
            
            $table->foreign('build_id')->references('id')->on('builds')->onDelete('cascade');
            $table->foreign('decoration_id')->references('id')->on('decorations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_decorations');
    }
};

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
        Schema::create('weapon_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_id')->constrained()->onDelete('cascade')->comment('武器ID');
            $table->integer('size')->comment('スロットサイズ');
            $table->integer('position')->comment('スロット位置');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapon_slots');
    }
};

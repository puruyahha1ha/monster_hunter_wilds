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
            $table->foreignId('series_id')->constrained()->onDelete('cascade')->comment('シリーズID');
            $table->foreignId('group_id')->nullable()->constrained()->onDelete('cascade')->comment('グループID');
            $table->string('name')->comment('防具名');
            $table->string('type')->comment('部位');
            $table->integer('rarity')->comment('レアリティ');
            $table->integer('defense')->comment('防御力');
            $table->integer('fire_resistance')->comment('火耐性');
            $table->integer('water_resistance')->comment('水耐性');
            $table->integer('thunder_resistance')->comment('雷耐性');
            $table->integer('ice_resistance')->comment('氷耐性');
            $table->integer('dragon_resistance')->comment('龍耐性');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('armors', function (Blueprint $table) {
            $table->dropForeign(['series_id']);
            $table->dropForeign(['group_id']);
        });
        Schema::dropIfExists('armors');
    }
};

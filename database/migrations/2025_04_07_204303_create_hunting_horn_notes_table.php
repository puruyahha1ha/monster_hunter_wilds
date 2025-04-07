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
        // 音色マスターテーブル
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->enum('color', ['赤', '青', '緑', '黄', '白', '紫', '水色', 'オレンジ'])->comment('音色');
            $table->enum('display', ['crotchet', 'quaver', 'quavers'])->comment('音符の表示');
            $table->timestamps();
        });

        // 響玉マスターテーブル
        Schema::create('echo_jewels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('響玉名');
            $table->text('description')->comment('響玉効果説明');
            $table->unsignedSmallInteger('duration')->default(0)->comment('効果持続時間（秒）');
            $table->timestamps();
        });

        // 旋律マスターテーブル
        Schema::create('melodies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('旋律名');
            $table->text('description')->comment('旋律効果説明');
            $table->unsignedSmallInteger('duration')->default(0)->comment('効果持続時間（秒）');
            $table->timestamps();
        });

        // 狩猟笛テーブル
        Schema::create('hunting_horn_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_id')->constrained('weapons')->onDelete('cascade')->comment('武器ID');
            $table->foreignId('first_note_id')->nullable()->constrained('notes')->onDelete('set null')->comment('1音色ID');
            $table->foreignId('second_note_id')->nullable()->constrained('notes')->onDelete('set null')->comment('2音色ID');
            $table->foreignId('third_note_id')->nullable()->constrained('notes')->onDelete('set null')->comment('3音色ID');
            $table->foreignId('echo_jewel_id')->nullable()->constrained('echo_jewels')->onDelete('set null')->comment('響玉ID');
            $table->timestamps();
        });

        // 狩猟笛旋律テーブル
        Schema::create('weapon_melody', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_id')->constrained('weapons')->onDelete('cascade')->comment('武器ID');
            $table->foreignId('melody_id')->constrained('melodies')->onDelete('cascade')->comment('旋律ID');
            $table->foreignId('first_note_id')->nullable()->constrained('notes')->onDelete('set null')->comment('1音色ID');
            $table->foreignId('second_note_id')->nullable()->constrained('notes')->onDelete('set null')->comment('2音色ID');
            $table->foreignId('third_note_id')->nullable()->constrained('notes')->onDelete('set null')->comment('3音色ID');
            $table->foreignId('fourth_note_id')->nullable()->constrained('notes')->onDelete('set null')->comment('4音色ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapon_melody');
        Schema::dropIfExists('hunting_horn_details');
        Schema::dropIfExists('melodies');
        Schema::dropIfExists('echo_jewels');
        Schema::dropIfExists('notes');
    }
};

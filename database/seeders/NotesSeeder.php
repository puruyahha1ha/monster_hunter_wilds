<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Note;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 音色マスターテーブル
        Note::insert([
            ['color' => '白', 'display' => 'crotchet'],
            ['color' => '紫', 'display' => 'crotchet'],
            ['color' => '赤', 'display' => 'quaver'],
            ['color' => '青', 'display' => 'quaver'],
            ['color' => '緑', 'display' => 'quaver'],
            ['color' => '水色', 'display' => 'quaver'],
            ['color' => '黄', 'display' => 'quavers'],
            ['color' => '青', 'display' => 'quavers'],
            ['color' => '緑', 'display' => 'quavers'],
            ['color' => '水色', 'display' => 'quavers'],
            ['color' => 'オレンジ', 'display' => 'quavers'],
        ]);
    }
}

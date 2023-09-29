<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            'type' => 'シングル',
            'room_count' => 5,
        ]);

        DB::table('rooms')->insert([
            'type' => 'ダブル',
            'room_count' => 4,
        ]);

        DB::table('rooms')->insert([
            'type' => 'スイート',
            'room_count' => 3,
        ]);
    }
}

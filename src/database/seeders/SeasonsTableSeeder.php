<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seasons = [
            ['id' => 1, 'name' => '春'],
            ['id' => 2, 'name' => '夏'],
            ['id' => 3, 'name' => '秋'],
            ['id' => 4, 'name' => '冬'],
        ];

        $selectedSeasonIds = [1, 2, 3, 4];

        foreach ($seasons as $season) {
            DB::table('seasons')->insert([
                'name' => $season['name'],
            ]);
        }
    }
}
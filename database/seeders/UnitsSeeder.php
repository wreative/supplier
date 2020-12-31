<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            [
                'id' => '1',
                'name' => 'biji',
            ],
            [
                'id' => '2',
                'name' => 'kantong',
            ],
            [
                'id' => '3',
                'name' => 'kodi',
            ],
            [
                'id' => '4',
                'name' => 'kotak',
            ],
            [
                'id' => '5',
                'name' => 'lembar',
            ],
            [
                'id' => '6',
                'name' => 'lusin',
            ],
            [
                'id' => '7',
                'name' => 'pack',
            ],
            [
                'id' => '8',
                'name' => 'pcs',
            ],
            [
                'id' => '9',
                'name' => 'units',
            ],
        ]);
    }
}

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
                'name' => 'Biji',
            ],
            [
                'id' => '2',
                'name' => 'Kantong',
            ],
            [
                'id' => '3',
                'name' => 'Kodi',
            ],
            [
                'id' => '4',
                'name' => 'Kotak',
            ],
            [
                'id' => '5',
                'name' => 'Lembar',
            ],
            [
                'id' => '6',
                'name' => 'Lusin',
            ],
            [
                'id' => '7',
                'name' => 'Pack',
            ],
            [
                'id' => '8',
                'name' => 'Pcs',
            ],
            [
                'id' => '9',
                'name' => 'Units',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment')->insert([
            [
                'id' => '1',
                'name' => 'Tunai',
            ],
            [
                'id' => '2',
                'name' => 'Transfer Bank'
            ],
            [
                'id' => '3',
                'name' => 'Non Tunai'
            ],
            [
                'id' => '4',
                'name' => 'Lainnya'
            ]
        ]);
    }
}

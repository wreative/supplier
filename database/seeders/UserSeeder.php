<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'Supplier',
                'username' => 'supplier',
                'password' => Hash::make(1234567890),
                'role_id' => '1'
            ]
        ]);
    }
}

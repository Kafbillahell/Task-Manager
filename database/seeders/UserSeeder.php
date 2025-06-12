<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            'id' => 1,
            'name' => 'ahayy',
            'email' => 'ahayy@gmail.com',
            'password' => '123',
        ];

        DB::table('users')->insert($data);
    }
}

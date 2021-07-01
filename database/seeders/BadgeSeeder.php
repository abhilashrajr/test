<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badge')->insert(array([
            'id'=>1,
            'name' => 'Best seller',
            'color' => '',
            'image' => '',
             'status' =>1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id'=>2,
            'name' => 'Must Try',
            'color' => '',
            'image' => '',
             'status' =>1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id'=>3,
            'name' => 'Hot',
            'color' => '',
            'image' => '',
             'status' =>1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id'=>4,
            'name' => 'Spicy',
            'color' => '',
            'image' => '',
             'status' =>1,
            'created_at' => now(),
            'updated_at' => now()
        ]
        )    

    );
    }
}

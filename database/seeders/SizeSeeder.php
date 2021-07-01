<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('sizes')->insert(array([
            'name' => 'Small',
            'sort_order' =>1,
            'active' =>1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Large',
            'sort_order' =>2,
            'active' =>1,
            'created_at' => now(),
            'updated_at' => now()
        ])    

    );
    }
}

<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_types')->insert(array([
                'id'=>2,
                'name' => 'Delivery / Collection',
                'description' => '',
                'image' => '',
                'sort_order' =>1,
                'active' =>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id'=>3,
                'name' => 'Dine In',
                'description' => '',
                'image' => '',
                'sort_order' =>2,
                'active' =>1,
                'created_at' => now(),
                'updated_at' => now()
            ])    
    
        );
    }
}
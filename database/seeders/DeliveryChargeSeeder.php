<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('delivery_charges')->insert(array([
                'type' => 'free',
                'rate' =>0,
                'free' =>0,
                'created_at' => now(),
                'updated_at' => now()
            ])
        );
    }
}

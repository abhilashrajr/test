<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name' => 'Joo',
            'logo' => '1611295222.svg',
            'contact_no' => '',
            'contact_no2' => '',
            'email' => '',
            'latitude' => '',
            'longitude' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'postcode' => '',
            'delivery' => 1,
            'collection' => 1,
            'active' => 1,
            'test_mode' => 1,
            'pre_order' => 0,
            'reject_order' => 0,
            'booking' => 0,
            'dinein' => 0,
            'paynow' => 0,
            'delivery_radius' => 5,
            'collection_min' => 0,
            'food_discount' => 0,
            'drinks_discount' => 0,
            'preorder_start' => NULL,
            'stripe_id' => '',
            'erp_id' => NULL,
            'theme' => 'menu-long-list',
            'currency' => '£',
            'created_at' => now(),
            'updated_at' => now()
           
        ]);
    }
}

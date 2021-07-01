<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert(array([
                'id'=>1,
                'name' => 'Card',
                'active' =>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id'=>2,
                'name' => 'Cash',
                'active' =>1,
                'created_at' => now(),
                'updated_at' => now()
            ])
        );
    }
}

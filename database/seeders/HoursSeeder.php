<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class HoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hours')->insert(array([
            'day' => '0',
            'active'=>1,
            'start1' =>'10:00:00',
            'end1' =>'13:00:00',
            'start2' =>'16:00:00',
            'end2' =>'22:00:00',
            'offer'=>0,
            'offer_coll'=>0,
            'offer_deli'=>0,
            'coll_min'=>0,
            'deli_min'=>0,
            'offer_payn'=>0,
            'payn_min'=>0,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'day' => '1',
            'active'=>1,
            'start1' =>'10:00:00',
            'end1' =>'13:00:00',
            'start2' =>'16:00:00',
            'end2' =>'22:00:00',
            'offer'=>0,
            'offer_coll'=>0,
            'offer_deli'=>0,
            'coll_min'=>0,
            'deli_min'=>0,
            'offer_payn'=>0,
            'payn_min'=>0,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'day' => '2',
            'active'=>1,
            'start1' =>'10:00:00',
            'end1' =>'13:00:00',
            'start2' =>'16:00:00',
            'end2' =>'22:00:00',
            'offer'=>0,
            'offer_coll'=>0,
            'offer_deli'=>0,
            'coll_min'=>0,
            'deli_min'=>0,
            'offer_payn'=>0,
            'payn_min'=>0,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'day' => '3',
            'active'=>1,
            'start1' =>'10:00:00',
            'end1' =>'13:00:00',
            'start2' =>'16:00:00',
            'end2' =>'22:00:00',
            'offer'=>0,
            'offer_coll'=>0,
            'offer_deli'=>0,
            'coll_min'=>0,
            'deli_min'=>0,
            'offer_payn'=>0,
            'payn_min'=>0,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'day' => '4',
            'active'=>1,
            'start1' =>'10:00:00',
            'end1' =>'13:00:00',
            'start2' =>'16:00:00',
            'end2' =>'22:00:00',
            'offer'=>0,
            'offer_coll'=>0,
            'offer_deli'=>0,
            'coll_min'=>0,
            'deli_min'=>0,
            'offer_payn'=>0,
            'payn_min'=>0,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'day' => '5',
            'active'=>1,
            'start1' =>'10:00:00',
            'end1' =>'13:00:00',
            'start2' =>'16:00:00',
            'end2' =>'22:00:00',
            'offer'=>0,
            'offer_coll'=>0,
            'offer_deli'=>0,
            'coll_min'=>0,
            'deli_min'=>0,
            'offer_payn'=>0,
            'payn_min'=>0,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'day' => '6',
            'active'=>1,
            'start1' =>'10:00:00',
            'end1' =>'13:00:00',
            'start2' =>'16:00:00',
            'end2' =>'22:00:00',
            'offer'=>0,
            'offer_coll'=>0,
            'offer_deli'=>0,
            'coll_min'=>0,
            'deli_min'=>0,
            'offer_payn'=>0,
            'payn_min'=>0,
            'created_at' => now(),
            'updated_at' => now()
        ]
       
       
        )
    );
    }
}

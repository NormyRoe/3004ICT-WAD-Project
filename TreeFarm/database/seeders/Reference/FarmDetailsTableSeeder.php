<?php

namespace Database\Seeders\Reference;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FarmDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('farm_details')->insert([

            [
                'name'               => 'Logan River Tree Farm',
                'street_address_1'   => '59-63 Chapman Drive',
                'street_address_2'   => null,
                'suburb'             => 'Beenleigh',
                'postcode'           => '4207',
                'created_by'         => null,
                'modified_by'        => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],

        ]);

    }
}

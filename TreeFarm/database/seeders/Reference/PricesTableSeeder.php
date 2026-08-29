<?php

namespace Database\Seeders\Reference;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('prices')->insert([

            // Pot size prices (name intentionally null)
            [
                'name'         => null,
                'pot_size_id'  => 1,
                'price'        => null,
                'rate'         => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => null,
                'pot_size_id'  => 2,
                'price'        => 55,
                'rate'         => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => null,
                'pot_size_id'  => 3,
                'price'        => 115,
                'rate'         => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => null,
                'pot_size_id'  => 4,
                'price'        => 275,
                'rate'         => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => null,
                'pot_size_id'  => 5,
                'price'        => 395,
                'rate'         => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // Delivery rate
            [
                'name'         => 'Delivery Rate',
                'pot_size_id'  => null,
                'price'        => 2.5,
                'rate'         => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // Delivery minimum
            [
                'name'         => 'Delivery Minimum',
                'pot_size_id'  => null,
                'price'        => 110,
                'rate'         => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // GST
            [
                'name'         => 'GST',
                'pot_size_id'  => null,
                'price'        => null,
                'rate'         => 10,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

        ]);
        
    }
}

<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('inventories')->insert([

            [
                'tree_id'      => 3,
                'pot_size_id'  => 2,
                'location_id'  => 1,
                'quantity'     => 300,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            [
                'tree_id'      => 6,
                'pot_size_id'  => 2,
                'location_id'  => 18,
                'quantity'     => 300,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            [
                'tree_id'      => 12,
                'pot_size_id'  => 3,
                'location_id'  => 25,
                'quantity'     => 500,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            [
                'tree_id'      => 6,
                'pot_size_id'  => 3,
                'location_id'  => 19,
                'quantity'     => 500,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            [
                'tree_id'      => 14,
                'pot_size_id'  => 5,
                'location_id'  => 69,
                'quantity'     => 200,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

        ]);
        
    }
}

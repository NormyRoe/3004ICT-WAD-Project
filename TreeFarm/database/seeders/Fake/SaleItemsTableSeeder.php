<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('sale_items')->insert([

            [
                'sales_id'      => 1,
                'inventory_id'  => 4,
                'quantity'      => 20,
                'common_name'   => 'Compact Lilly Pilly',
                'pot_size'      => '45 lt',
                'unit_price'    => 55,
                'discount'      => 0,
                'total_price'   => 1100,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'sales_id'      => 1,
                'inventory_id'  => 1,
                'quantity'      => 30,
                'common_name'   => 'Northern form Lilly Pilly',
                'pot_size'      => '25 lt',
                'unit_price'    => 115,
                'discount'      => 200,
                'total_price'   => 3250,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'sales_id'      => 2,
                'inventory_id'  => 2,
                'quantity'      => 10,
                'common_name'   => 'Compact Lilly Pilly',
                'pot_size'      => '25 lt',
                'unit_price'    => 275,
                'discount'      => 0,
                'total_price'   => 2750,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'sales_id'      => 3,
                'inventory_id'  => 3,
                'quantity'      => 5,
                'common_name'   => 'Weeping Lilly Pilly',
                'pot_size'      => '45 lt',
                'unit_price'    => 395,
                'discount'      => 0,
                'total_price'   => 1975,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'sales_id'      => 3,
                'inventory_id'  => 5,
                'quantity'      => 40,
                'common_name'   => 'Blush Satinash Hinterland',
                'pot_size'      => '150 lt',
                'unit_price'    => 55,
                'discount'      => 0,
                'total_price'   => 10200,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

        ]);
        
    }
}

<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('sales')->insert([

            [
                'customer_id'        => 2,
                'user_id'            => 4,
                'date'               => '2026-07-12',
                'delivery_notes'     => 'Enter code 448 to enter community gate',
                'delivery_kms'       => 2,
                'delivery_fee'       => 115,
                'discount'           => 0,
                'total_sales_price'  => 4000,
                'status'             => 'Awaiting Payment',
                'created_by'         => null,
                'modified_by'        => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],

            [
                'customer_id'        => 1,
                'user_id'            => 2,
                'date'               => '2026-07-20',
                'delivery_notes'     => null,
                'delivery_kms'       => 5,
                'delivery_fee'       => 250,
                'discount'           => 100,
                'total_sales_price'  => 5500,
                'status'             => 'Awaiting Delivery',
                'created_by'         => null,
                'modified_by'        => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],

            [
                'customer_id'        => 2,
                'user_id'            => 4,
                'date'               => '2026-05-22',
                'delivery_notes'     => 'Enter code 448 to enter community gate',
                'delivery_kms'       => 2,
                'delivery_fee'       => 115,
                'discount'           => 300,
                'total_sales_price'  => 10500,
                'status'             => 'Delivered',
                'created_by'         => null,
                'modified_by'        => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],

        ]);
        
    }
}

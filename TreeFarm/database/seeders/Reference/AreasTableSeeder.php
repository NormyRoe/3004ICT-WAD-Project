<?php

namespace Database\Seeders\Reference;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('areas')->insert([

            [
                'name'        => 'Seedling',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Growing',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Selling',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Potting 1',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Potting 2',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Delivery',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Disposal',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

        ]);
        
    }
}

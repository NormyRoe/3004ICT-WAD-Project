<?php

namespace Database\Seeders\Reference;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('roles')->insert([

            [
                'name'        => 'Owner',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Operations',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Operational Manager',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Sales',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Sales Manager',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Field Hand',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Potter',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

        ]);

    }
}

<?php

namespace Database\Seeders\Reference;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('tasks')->insert([

            [
                'name'        => 'Report',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Re-Pot',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Move',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Destroy',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Prune',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'name'        => 'Weed',
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

        ]);

    }
}

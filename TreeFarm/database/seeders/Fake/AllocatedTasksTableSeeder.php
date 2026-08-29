<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllocatedTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('allocated_tasks')->insert([

            [
                'task_id'       => 3,
                'tree_id'       => 3,
                'location_1_id' => 18,
                'location_2_id' => 36,
                'pot_size_id'   => null,
                'date'          => '2026-07-11',
                'notes'         => null,
                'quantity'      => 200,
                'done'          => 0,
                'allocated'     => 1,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'task_id'       => 5,
                'tree_id'       => 6,
                'location_1_id' => 24,
                'location_2_id' => null,
                'pot_size_id'   => null,
                'date'          => '2026-07-11',
                'notes'         => null,
                'quantity'      => 100,
                'done'          => 0,
                'allocated'     => 1,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'task_id'       => 6,
                'tree_id'       => null,
                'location_1_id' => 8,
                'location_2_id' => null,
                'pot_size_id'   => null,
                'date'          => '2026-07-12',
                'notes'         => 'Weed all of the trees in the block',
                'quantity'      => null,
                'done'          => 0,
                'allocated'     => 1,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'task_id'       => 2,
                'tree_id'       => 6,
                'location_1_id' => 2,
                'location_2_id' => null,
                'pot_size_id'   => 3,
                'date'          => '2026-07-12',
                'notes'         => null,
                'quantity'      => 70,
                'done'          => 0,
                'allocated'     => 0,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'task_id'       => 1,
                'tree_id'       => null,
                'location_1_id' => 56,
                'location_2_id' => null,
                'pot_size_id'   => null,
                'date'          => '2026-07-13',
                'notes'         => 'The plants have a bug eating the leaves',
                'quantity'      => null,
                'done'          => 0,
                'allocated'     => 1,
                'created_by'    => null,
                'modified_by'   => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

        ]);

    }
}

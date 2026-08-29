<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllocatedTasksUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('allocated_tasks_users')->insert([

            [
                'allocated_task_id' => 1,
                'user_id'           => 6,
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'allocated_task_id' => 2,
                'user_id'           => 4,
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'allocated_task_id' => 3,
                'user_id'           => 8,
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'allocated_task_id' => 3,
                'user_id'           => 5,
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'allocated_task_id' => 3,
                'user_id'           => 6,
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'allocated_task_id' => 5,
                'user_id'           => 3,
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'allocated_task_id' => 5,
                'user_id'           => 2,
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

        ]);
        
    }
}

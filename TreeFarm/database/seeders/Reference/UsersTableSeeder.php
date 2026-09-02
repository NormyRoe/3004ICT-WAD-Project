<?php

namespace Database\Seeders\Reference;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/

        DB::table('users')->insert([
            [
                'first_name'  => 'admin',
                'last_name'   => 'admin',
                'username'    => 'admin',
                'email'       => 'admin@dob.com',
                'job_title'   => 'admin',
                'manager_id'  => null,
                'status'      => 'Approved',
                'password'    => bcrypt('ella99@Treefarm'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders\Fake;

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
                'first_name'  => 'Sally',
                'last_name'   => 'Logbottom',
                'username'    => 'sallylog',
                'email'       => 'sally@dob.com',
                'job_title'   => 'Sales Manager',
                'manager_id'  => null,
                'status'      => 'Approved',
                'password'    => bcrypt('sally809@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'first_name'  => 'Henry',
                'last_name'   => 'White',
                'username'    => 'wenwh',
                'email'       => 'henry@dob.com',
                'job_title'   => 'Operations Manager',
                'manager_id'  => null,
                'status'      => 'Approved',
                'password'    => bcrypt('henry603@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'first_name'  => 'Bob',
                'last_name'   => 'Brown',
                'username'    => 'bobby',
                'email'       => 'bob@dob.com',
                'job_title'   => 'Sales Assistant',
                'manager_id'  => 2,
                'status'      => 'Approved',
                'password'    => bcrypt('bob101@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'first_name'  => 'Lucy',
                'last_name'   => 'Blue',
                'username'    => 'lucbl',
                'email'       => 'lucy@dob.com',
                'job_title'   => 'Operations Assistant',
                'manager_id'  => 3,
                'status'      => 'Inactive',
                'password'    => bcrypt('lucy505@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'first_name'  => 'Dylan',
                'last_name'   => 'Bright',
                'username'    => 'dylanbr',
                'email'       => 'bright@dob.com',
                'job_title'   => 'Field Hand',
                'manager_id'  => 3,
                'status'      => 'Approved',
                'password'    => bcrypt('dylan504@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'first_name'  => 'Lucas',
                'last_name'   => 'Tight',
                'username'    => 'luctig',
                'email'       => 'tight@dod.com',
                'job_title'   => 'Potter',
                'manager_id'  => 3,
                'status'      => 'Approved',
                'password'    => bcrypt('lucas804@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'first_name'  => 'Tom',
                'last_name'   => 'Feint',
                'username'    => 'tomfei',
                'email'       => 'feint@dob.com',
                'job_title'   => 'All rounder',
                'manager_id'  => 2,
                'status'      => 'Approved',
                'password'    => bcrypt('feint202@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            [
                'first_name'  => 'Rent',
                'last_name'   => 'Vieve',
                'username'    => 'rentv',
                'email'       => 'vieve@dob.com',
                'job_title'   => 'Potter',
                'manager_id'  => 3,
                'status'      => 'For Approval',
                'password'    => bcrypt('rentv509@TF'),
                'created_by'  => null,
                'modified_by' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

        ]);

    }
}

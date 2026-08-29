<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExceptionPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('exception_prices')->insert([

            // Tree 21
            [ 'tree_id' => 21, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 21, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 21, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 21, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            // Tree 26
            [ 'tree_id' => 26, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 26, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 26, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 26, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            // Tree 49
            [ 'tree_id' => 49, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 49, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 49, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 49, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            // Tree 50
            [ 'tree_id' => 50, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 50, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 50, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 50, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            // Tree 48
            [ 'tree_id' => 48, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 48, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 48, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 48, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            // Tree 15
            [ 'tree_id' => 15, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 15, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 15, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 15, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            // Tree 59
            [ 'tree_id' => 59, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 59, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 59, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 59, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            // Tree 29
            [ 'tree_id' => 29, 'pot_size_id' => 2, 'price' => 99,  'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 29, 'pot_size_id' => 3, 'price' => 187, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 29, 'pot_size_id' => 4, 'price' => 385, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'tree_id' => 29, 'pot_size_id' => 5, 'price' => 495, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

        ]);
        
    }
}

<?php

namespace Database\Seeders\Reference;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        


        DB::table('locations')->insert([

            /***************************************************
            
                Area only
            
            ****************************************************/
            [
                'area_id'      => 1,
                'block_id'     => null,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 4,
                'block_id'     => null,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 5,
                'block_id'     => null,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 6,
                'block_id'     => null,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 7,
                'block_id'     => null,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            /***************************************************
            
                Area + Block
            
            ****************************************************/
            [
                'area_id'      => 2,
                'block_id'     => 1,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 2,
                'block_id'     => 2,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 2,
                'block_id'     => 3,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 2,
                'block_id'     => 4,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 2,
                'block_id'     => 5,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 2,
                'block_id'     => 6,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            [
                'area_id'      => 3,
                'block_id'     => 7,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 3,
                'block_id'     => 8,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 3,
                'block_id'     => 9,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 3,
                'block_id'     => 10,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 3,
                'block_id'     => 11,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'area_id'      => 3,
                'block_id'     => 12,
                'aisle_id'     => null,
                'created_by'   => null,
                'modified_by'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            /***************************************************
            
                Area + Block + Aisle
            
            ****************************************************/

            /* Area 2, Block 1 */
            [ 'area_id' => 2, 'block_id' => 1, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 1, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 1, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 1, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 1, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 2, Block 2 */
            [ 'area_id' => 2, 'block_id' => 2, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 2, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 2, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 2, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 2, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 2, Block 3 */
            [ 'area_id' => 2, 'block_id' => 3, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 3, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 3, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 3, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 3, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 2, Block 4 */
            [ 'area_id' => 2, 'block_id' => 4, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 4, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 4, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 4, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 4, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 2, Block 5 */
            [ 'area_id' => 2, 'block_id' => 5, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 5, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 5, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 5, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 5, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 2, Block 6 */
            [ 'area_id' => 2, 'block_id' => 6, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 6, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 6, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 6, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 2, 'block_id' => 6, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 3, Block 7 */
            [ 'area_id' => 3, 'block_id' => 7, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 7, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 7, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 7, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 7, 'aisle_id' => 5, 'created_by' => null,  
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 3, Block 8 */
            [ 'area_id' => 3, 'block_id' => 8, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 8, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 8, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 8, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 8, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 3, Block 9 */
            [ 'area_id' => 3, 'block_id' => 9, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 9, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 9, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 9, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 9, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 3, Block 10 */
            [ 'area_id' => 3, 'block_id' => 10, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 10, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 10, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 10, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 10, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 3, Block 11 */
            [ 'area_id' => 3, 'block_id' => 11, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 11, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 11, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 11, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 11, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            /* Area 3, Block 12 */
            [ 'area_id' => 3, 'block_id' => 12, 'aisle_id' => 1, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 12, 'aisle_id' => 2, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 12, 'aisle_id' => 3, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

            [ 'area_id' => 3, 'block_id' => 12, 'aisle_id' => 4, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],
                
            [ 'area_id' => 3, 'block_id' => 12, 'aisle_id' => 5, 'created_by' => null, 
                'modified_by' => null, 'created_at' => now(), 'updated_at' => now() ],

        ]);
    }
}

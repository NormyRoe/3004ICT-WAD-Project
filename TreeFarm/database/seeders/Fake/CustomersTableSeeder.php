<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***************************************************
        
            Insert Data
            
        ****************************************************/
        
        DB::table('customers')->insert([

            [
                'first_name'        => 'Henry',
                'last_name'         => 'Bloke',
                'company'           => 'Dorothy Enterprises',
                'phone_number'      => '41254758',
                'email'             => 'henry@buy.com',
                'street_address_1'  => '7 Fitzroy Street',
                'street_address_2'  => '',
                'suburb'            => 'Holmview',
                'postcode'          => '4207',
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'first_name'        => 'Susan',
                'last_name'         => 'Boil',
                'company'           => 'Sunset Planters',
                'phone_number'      => '42568459',
                'email'             => 'susan@wow.com',
                'street_address_1'  => '6 Hovea Street',
                'street_address_2'  => '',
                'suburb'            => 'Coomera',
                'postcode'          => '4209',
                'created_by'        => null,
                'modified_by'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

        ]);
        
    }
}

<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/* Import Reference and Fake Data Seeder namespaces */
use Database\Seeders\Reference as Reference;
use Database\Seeders\Fake as Fake;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        /***************************************************
        
            Reference Data
            
        ****************************************************/
        $this->call([
            Reference\UsersTableSeeder::class,
            Reference\RolesTableSeeder::class,
            Reference\UsersRolesTableSeeder::class,
            Reference\PotSizesTableSeeder::class,
            Reference\TreeTypesTableSeeder::class,
            Reference\BlocksTableSeeder::class,
            Reference\AislesTableSeeder::class,
            Reference\AreasTableSeeder::class,
            Reference\LocationsTableSeeder::class,
            Reference\PricesTableSeeder::class,
            Reference\TasksTableSeeder::class,
            Reference\FarmDetailsTableSeeder::class,
        ]);
        


        /***************************************************
        
            Fake Data
            
        ****************************************************/
        $this->call([
            Fake\UsersTableSeeder::class,
            Fake\UsersRolesTableSeeder::class,
            Fake\TreesTableSeeder::class,
            Fake\InventoriesTableSeeder::class,
            Fake\ExceptionPricesTableSeeder::class,
            Fake\AllocatedTasksTableSeeder::class,
            Fake\AllocatedTasksUsersTableSeeder::class,
            Fake\CustomersTableSeeder::class,
            Fake\SalesTableSeeder::class,
            Fake\SaleItemsTableSeeder::class,
        ]);

    }
}

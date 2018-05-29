<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTablesSeeder::class,
            UsersTableSeeder::class,
            UserAuthsTableSeeder::class,
            EquipmentCategoriesTableSeeder::class,
            CachesFlushSeeder::class,
            ServicesTableSeeder::class,
//            AssessesTableSeeder::class,
        ]);
    }
}

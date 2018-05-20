<?php

use Illuminate\Database\Seeder;

class EquipmentCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EquipmentCategory::saveAll([
            ['name' => '血压仪', 'price' => 299],
            ['name' => '血糖仪', 'price' => 299]
        ]);
    }
}

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
//            ['name' => '自备设备', 'price' => 199],
            ['name' => '血压计', 'price' => 299],
            ['name' => '血糖仪', 'price' => 299],
            ['name' => '心电手环', 'price' => 299],
            ['name' => '三合一慢病检测仪', 'price' => 499],
        ]);
    }
}

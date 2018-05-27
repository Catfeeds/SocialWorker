<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Service::saveAll([
            ['name' => '血压检测', 'price' => 266],
            ['name' => '体脂检测', 'price' => 266]
        ]);
    }
}

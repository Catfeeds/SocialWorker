<?php

use Illuminate\Database\Seeder;

class CachesFlushSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cache::forget('wx_access_token');
    }
}

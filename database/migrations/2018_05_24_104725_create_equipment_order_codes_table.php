<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentOrderCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_order_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipment_order_id');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `equipment_order_codes` ADD `code` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_order_codes');
    }
}

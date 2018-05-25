<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('order_no');
            $table->decimal('price');
            $table->decimal('raise')->default(0);
            $table->json('snap_content');
            $table->tinyInteger('type')->default(1)->comment('1购买 2众筹');
            $table->tinyInteger('status')->default(0)->comment('0未支付 1已支付');
            $table->string('prepay_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_orders');
    }
}

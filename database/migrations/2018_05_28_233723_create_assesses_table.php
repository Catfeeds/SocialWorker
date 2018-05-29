<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('score');
            $table->tinyInteger('type')->comment('1个人病史 2从事职业 3家族遗传 4生活状态 5日常体征');
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
        Schema::dropIfExists('assesses');
    }
}

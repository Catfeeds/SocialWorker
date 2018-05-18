<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `invitation_codes` ADD `code` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitation_codes');
    }
}

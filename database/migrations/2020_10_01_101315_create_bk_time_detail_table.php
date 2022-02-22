<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBkTimeDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bk_time_detail', function (Blueprint $table) {
            $table->bigIncrements('bkdetailID');
            $table->string('Day');
            $table->time('startTime');
            $table->time('endTime');
            $table->integer('classID');
            $table->integer('bktimeID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bk_time_detail');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamAnsRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_ans_record', function (Blueprint $table) {
            $table->id();
            $table->string('studentID');
            $table->integer('questionID');
            $table->longText('answer');
            $table->integer('mark');
            $table->longText('reply');
            $table->integer('examID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_ans_record');
    }
}

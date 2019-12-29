<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('subject_user_id')->unsigned();
            $table->mediumInteger('student_id')->unsigned();
            $table->string('lectures_id' , 70);
            $table->tinyInteger('count_all_lectures')->unsigned(); //255


            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_user_id')->references('id')->on('subject_users')->onDelete('cascade');

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
        Schema::dropIfExists('attendances');
    }
}

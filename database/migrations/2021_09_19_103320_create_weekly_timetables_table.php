<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_timetables', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('day_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('room_id')->references('id')->on('school_class_rooms');
            $table->foreign('day_id')->references('id')->on('default_school_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_timetables');
    }
}

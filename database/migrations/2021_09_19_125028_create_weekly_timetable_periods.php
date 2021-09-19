<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyTimetablePeriods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_timetable_periods', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('timetable_id')->unsigned();
            $table->bigInteger("period_id")->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('timetable_id')->references('id')->on('weekly_timetables');
            $table->foreign('period_id')->references('id')->on('default_school_daily_periods');
            $table->foreign('subject_id')->references('id')->on('school_class_subjects');
            $table->foreign('teacher_id')->references('id')->on('school_teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_timetable_periods');
    }
}

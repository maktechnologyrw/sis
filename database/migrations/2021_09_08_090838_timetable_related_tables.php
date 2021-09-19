<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TimetableRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("school_day_times", function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->time("start_time");
            $table->time("end_time");

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
        });

        Schema::create("breaks_and_lunches", function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->string("category");
            $table->time("start_time");
            $table->time("end_time");

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
        });

        Schema::create('default_school_days', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->string("day_of_the_week");
            $table->boolean("status")->default(false);

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
        });

        Schema::create('default_daily_period_durations', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->integer('duration');
            $table->enum('extension', ['Hours', 'Minutes', 'Seconds']);

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
        });

        Schema::create('default_school_daily_periods', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->string("category");
            $table->time("since");
            $table->time("until");

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_day_times');
        Schema::dropIfExists('breaks_and_lunches');
        Schema::dropIfExists('default_school_days');
        Schema::dropIfExists('default_daily_period_durations');
        Schema::dropIfExists('default_school_daily_periods');
        Schema::dropIfExists('weekly_timetables');
    }
}

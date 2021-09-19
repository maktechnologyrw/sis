<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttendaceRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_lists', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->date('date');

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('room_id')->references('id')->on('school_class_rooms');
            $table->foreign('teacher_id')->references('id')->on('school_teachers');
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('list_id')->unsigned();
            $table->bigInteger('enrollment_id')->unsigned();
            $table->boolean('attended')->default(true);
            $table->text('comment')->nullable();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('list_id')->references('id')->on('attendance_lists');
            $table->foreign('enrollment_id')->references('id')->on('enrollments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_list');
        Schema::dropIfExists('attendance');
    }
}

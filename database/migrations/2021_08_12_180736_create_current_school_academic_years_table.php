<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentSchoolAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_school_academic_years', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned()->unique();
            $table->bigInteger('year_id')->unsigned();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_school_academic_years');
    }
}

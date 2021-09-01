<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AcademicYearSpecificTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('school_id')->unsigned();
            $table->string('name');
            $table->date('since')->nullable();
            $table->date('until')->nullable();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
        });

        Schema::create('academic_year_terms', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('academic_year_id')->unsigned();
            $table->integer('number');
            $table->date('since')->nullable();
            $table->date('until')->nullable();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
        });

        Schema::create('school_teachers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('academic_year_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });

        Schema::create('academic_year_categories', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('category_id')->references('id')->on('school_class_categories');

            $table->primary(["school_id", "year_id", "category_id"]);
        });

        Schema::create('academic_year_levels', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('level_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('level_id')->references('id')->on('school_class_levels');

            $table->primary(["school_id", "year_id", "level_id"]);
        });

        Schema::create('academic_year_years', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('class_year_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('class_year_id')->references('id')->on('school_class_years');

            $table->primary(["school_id", "year_id", "class_year_id"]);
        });

        Schema::create('academic_year_rooms', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('room_id')->references('id')->on('school_class_rooms');

            $table->primary(["school_id", "year_id", "room_id"]);
        });

        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('class_year_id')->unsigned();
            $table->date('date');
            $table->string('status')->default('Waiting');
            $table->text('comment');

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('class_year_id')->references('id')->on('school_class_category_level_years');
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('registration_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
            $table->date('enrolled_at');
            $table->date('start_date')->nullable();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('registration_id')->references('id')->on('student_registrations');
            $table->foreign('room_id')->references('id')->on('school_class_rooms');
        });

        Schema::create('academic_subjects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('class_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('class_id')->references('id')->on('school_class_years');
            $table->foreign('subject_id')->references('id')->on('school_class_subjects');
        });

        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->string("name");

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('year_id')->references('id')->on('academic_years');
            $table->foreign('teacher_id')->references('id')->on('school_teachers');
            $table->foreign('subject_id')->references('id')->on('school_class_subjects');
        });

        Schema::create('markable_works', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('academic_year_id')->unsigned();
            $table->bigInteger('markable_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('term_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->string('name');
            $table->double("maximum_points");
            $table->date('done_on');
            $table->time('started_at')->nullable();
            $table->time('ended_at')->nullable();
            $table->boolean('is_report_candidate');

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('markable_id')->references('id')->on('school_markables');
            $table->foreign('teacher_id')->references('id')->on('school_teachers');
            $table->foreign('term_id')->references('id')->on('academic_year_terms');
            $table->foreign('subject_id')->references('id')->on('school_class_subjects');
        });

        Schema::create('marks', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('academic_year_id')->unsigned();
            $table->bigInteger('work_id')->unsigned();
            $table->bigInteger('enrollment_id')->unsigned();
            $table->double('marks');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('work_id')->references('id')->on('markable_works');
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
        Schema::dropIfExists('academic_years');
        Schema::dropIfExists('academic_year_terms');
        Schema::dropIfExists('school_teachers');
        Schema::dropIfExists('academic_year_categories');
        Schema::dropIfExists('academic_year_levels');
        Schema::dropIfExists('academic_year_years');
        Schema::dropIfExists('academic_year_rooms');
        Schema::dropIfExists('student_registrations');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('academic_subjects');
        Schema::dropIfExists('teacher_subjects');
        Schema::dropIfExists('markable_works');
        Schema::dropIfExists('marks');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GlobalTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('abbreviation')->unique();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('class_levels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->unique();
            $table->string('abbreviation')->unique();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('class_years', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->unique();
            $table->string('display_name');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('class_category_levels', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('class_category_id')->unsigned();
            $table->bigInteger('class_level_id')->unsigned();
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('class_category_id')->references('id')->on('class_categories');
            $table->foreign('class_level_id')->references('id')->on('class_levels');
        });

        Schema::create('class_category_level_years', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('level_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('level_id')->references('id')->on('class_category_levels');
            $table->foreign('year_id')->references('id')->on('class_years');
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('abbreviation');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('class_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->string('name');
            $table->double('minutes_per_week');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('class_category_level_years');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['Male', 'Female']);
            $table->date('date_of_birth');

            $table->bigInteger('birth_country_id')->unsigned()->nullable();

            $table->bigInteger('birth_province')->unsigned()->nullable();
            $table->bigInteger('birth_district')->unsigned()->nullable();
            $table->bigInteger('birth_sector')->unsigned()->nullable();
            $table->bigInteger('birth_cell')->unsigned()->nullable();
            $table->bigInteger('birth_village')->unsigned()->nullable();

            $table->bigInteger('residential_country_id')->unsigned()->nullable();

            $table->bigInteger('residential_province')->unsigned()->nullable();
            $table->bigInteger('residential_district')->unsigned()->nullable();
            $table->bigInteger('residential_sector')->unsigned()->nullable();
            $table->bigInteger('residential_cell')->unsigned()->nullable();
            $table->bigInteger('residential_village')->unsigned()->nullable();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('birth_country_id')->references('id')->on('countries');

            $table->foreign('birth_province')->references('provincecode')->on('provinces');
            $table->foreign('birth_district')->references('DistrictCode')->on('districts');
            $table->foreign('birth_sector')->references('SectorCode')->on('sectors');
            $table->foreign('birth_cell')->references('CellCode')->on('cells');
            $table->foreign('birth_village')->references('VillageCode')->on('villages');

            $table->foreign('residential_country_id')->references('id')->on('countries');

            $table->foreign('residential_province')->references('provincecode')->on('provinces');
            $table->foreign('residential_district')->references('DistrictCode')->on('districts');
            $table->foreign('residential_sector')->references('SectorCode')->on('sectors');
            $table->foreign('residential_cell')->references('CellCode')->on('cells');
            $table->foreign('residential_village')->references('VillageCode')->on('villages');
        });

        Schema::create('parenting_people', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('type', ['Father', 'Mother', 'Guardian'])->default("Father");
            $table->string('email');

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('student_parents', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('parent_id')->references('id')->on('parenting_people');
        });

        Schema::create('phones', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('country_id')->unsigned();
            $table->string('number', 15);
            $table->boolean('on_whatsapp')->default(0);

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::create('user_phones', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('phone_id')->unsigned();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('phone_id')->references('id')->on('phones');
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['Male', 'Female']);
            $table->date('date_of_birth');
            $table->string('email')->nullable();
            $table->string('degree')->nullable();
            $table->string('qualification')->nullable();

            $table->bigInteger('birth_country_id')->unsigned()->nullable();

            $table->bigInteger('birth_province')->unsigned()->nullable();
            $table->bigInteger('birth_district')->unsigned()->nullable();
            $table->bigInteger('birth_sector')->unsigned()->nullable();
            $table->bigInteger('birth_cell')->unsigned()->nullable();
            $table->bigInteger('birth_village')->unsigned()->nullable();

            $table->bigInteger('residential_country_id')->unsigned()->nullable();

            $table->bigInteger('residential_province')->unsigned()->nullable();
            $table->bigInteger('residential_district')->unsigned()->nullable();
            $table->bigInteger('residential_sector')->unsigned()->nullable();
            $table->bigInteger('residential_cell')->unsigned()->nullable();
            $table->bigInteger('residential_village')->unsigned()->nullable();

            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('birth_country_id')->references('id')->on('countries');

            $table->foreign('birth_province')->references('provincecode')->on('provinces');
            $table->foreign('birth_district')->references('DistrictCode')->on('districts');
            $table->foreign('birth_sector')->references('SectorCode')->on('sectors');
            $table->foreign('birth_cell')->references('CellCode')->on('cells');
            $table->foreign('birth_village')->references('VillageCode')->on('villages');

            $table->foreign('residential_country_id')->references('id')->on('countries');

            $table->foreign('residential_province')->references('provincecode')->on('provinces');
            $table->foreign('residential_district')->references('DistrictCode')->on('districts');
            $table->foreign('residential_sector')->references('SectorCode')->on('sectors');
            $table->foreign('residential_cell')->references('CellCode')->on('cells');
            $table->foreign('residential_village')->references('VillageCode')->on('villages');
        });

        Schema::create('markables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_report_candidate');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('yearly_marking_thresholds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('markable_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger("threshold");
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('markable_id')->references('id')->on('markables');
            $table->foreign('subject_id')->references('id')->on('class_subjects');
        });

        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->date('since')->nullable();
            $table->date('until')->nullable();
            $table->timestamps();
        });

        Schema::create('termly_marking_thresholds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('term_id')->unsigned();
            $table->bigInteger('markable_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger("threshold");
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('markable_id')->references('id')->on('markables');
            $table->foreign('subject_id')->references('id')->on('class_subjects');
        });

        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_categories');
        Schema::dropIfExists('class_levels');
        Schema::dropIfExists('class_years');
        Schema::dropIfExists('class_category_levels');
        Schema::dropIfExists('class_category_level_years');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('class_subjects');
        Schema::dropIfExists('students');
        Schema::dropIfExists('parenting_people');
        Schema::dropIfExists('parent_students');
        Schema::dropIfExists('phones');
        Schema::dropIfExists('user_phones');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('markables');
        Schema::dropIfExists('yearly_marking_thresholds');
        Schema::dropIfExists('terms');
        Schema::dropIfExists('termly_marking_thresholds');
        Schema::dropIfExists('dashboards');
    }
}

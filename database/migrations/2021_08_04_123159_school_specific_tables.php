<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SchoolSpecificTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("motto")->nullable();
            $table->year('established_at')->nullable();
            $table->bigInteger('province')->unsigned()->nullable();
            $table->bigInteger('district')->unsigned()->nullable();
            $table->bigInteger('sector')->unsigned()->nullable();
            $table->bigInteger('cell')->unsigned()->nullable();
            $table->bigInteger('village')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('province')->references('provincecode')->on('provinces');
            $table->foreign('district')->references('DistrictCode')->on('districts');
            $table->foreign('sector')->references('SectorCode')->on('sectors');
            $table->foreign('cell')->references('CellCode')->on('cells');
            $table->foreign('village')->references('VillageCode')->on('villages');
        });

        Schema::create('school_users', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('school_id')->unsigned();
            $table->string('user_type')->default('users');
            $table->string("foreign_model")->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'school_id', 'user_type']);
        });

        // ------------------Global Tables Copy Specific For School----------------------- //
        Schema::create('school_class_categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('abbreviation');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('school_class_levels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('abbreviation');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('school_class_years', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('display_name');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('school_class_category_levels', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('class_category_id')->unsigned();
            $table->bigInteger('class_level_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('class_category_id')->references('id')->on('school_class_categories');
            $table->foreign('class_level_id')->references('id')->on('school_class_levels');
        });

        Schema::create('school_class_category_level_years', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('level_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('school_class_category_levels');
            $table->foreign('year_id')->references('id')->on('school_class_years');
        });

        Schema::create('school_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('abbreviation');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('school_class_subjects', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('class_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->double('minutes_per_week');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('school_class_category_level_years');
            $table->foreign('subject_id')->references('id')->on('school_subjects');
        });

        Schema::create('school_dashboards', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index(['school_id']);
        });

        Schema::create('user_dashboards', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('dashboard_id')->unsigned();
            $table->string('user_type', 20)->default('users');

            $table->primary(['user_id', 'dashboard_id', 'user_type']);
        });

        Schema::create('school_markables', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->boolean('is_report_candidate');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('school_yearly_marking_thresholds', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('markable_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger("threshold");
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('markable_id')->references('id')->on('school_markables');
            $table->foreign('subject_id')->references('id')->on('school_class_subjects');
        });

        Schema::create('school_terms', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->integer('number');
            $table->date('since')->nullable();
            $table->date('until')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('school_termly_marking_thresholds', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('term_id')->unsigned();
            $table->bigInteger('markable_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger("threshold");
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('term_id')->references('id')->on('school_terms');
            $table->foreign('markable_id')->references('id')->on('school_markables');
            $table->foreign('subject_id')->references('id')->on('school_class_subjects');
        });

        Schema::create('school_class_rooms', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('year_id')->unsigned();
            $table->string('room');
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('year_id')->references('id')->on('school_class_category_level_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
        Schema::dropIfExists('school_users');
        Schema::dropIfExists('school_class_categories');
        Schema::dropIfExists('school_class_levels');
        Schema::dropIfExists('school_class_years');
        Schema::dropIfExists('school_class_category_levels');
        Schema::dropIfExists('school_class_category_level_years');
        Schema::dropIfExists('school_subjects');
        Schema::dropIfExists('school_class_subjects');
        Schema::dropIfExists('school_dashboards');
        Schema::dropIfExists('user_dashboards');
        Schema::dropIfExists('school_markables');
        Schema::dropIfExists('school_yearly_marking_thresholds');
        Schema::dropIfExists('school_terms');
        Schema::dropIfExists('school_termly_marking_thresholds');
        Schema::dropIfExists('school_class_rooms');
    }
}

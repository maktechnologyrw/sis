<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LocationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->char('iso', 2);
            $table->string('name', 80);
            $table->string('nicename', 80);
            $table->char('iso3', 3)->nullable();
            $table->smallInteger('numcode')->nullable();
            $table->integer('phonecode');
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->id('provincecode');
            $table->string('provincename');
            $table->string('displayname')->nullable();
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id('DistrictId');
            $table->bigInteger('ProvinceCode')->unsigned();
            $table->string('DistrictName');
            $table->bigInteger('DistrictCode')->unique()->unsigned();
            $table->string('DistrictStatus');
            $table->timestamps();

            $table->foreign('ProvinceCode')->references('provincecode')->on('provinces');

            $table->index('DistrictCode');
        });

        Schema::create('sectors', function (Blueprint $table) {
            $table->id('SectorId');
            $table->bigInteger('DistrictCode')->unsigned();
            $table->string('SectorName');
            $table->bigInteger('SectorCode')->unique()->unsigned();
            $table->string('SectorStatus');
            $table->timestamps();

            $table->foreign('DistrictCode')->references('DistrictCode')->on('districts');

            $table->index('SectorCode');
        });

        Schema::create('cells', function (Blueprint $table) {
            $table->id('CellId');
            $table->bigInteger('SectorCode')->unsigned();
            $table->string('CellName');
            $table->bigInteger('CellCode')->unique()->unsigned();
            $table->string('CellStatus');
            $table->timestamps();

            $table->foreign('SectorCode')->references('SectorCode')->on('sectors');

            $table->index('CellCode');
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->id('VillageId');
            $table->bigInteger('CellCode')->unsigned();
            $table->string('VillageName');
            $table->bigInteger('VillageCode')->unique()->unsigned();
            $table->string('VillageStatus');
            $table->timestamps();

            $table->foreign('CellCode')->references('CellCode')->on('cells');

            $table->index('VillageCode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('sectors');
        Schema::dropIfExists('cells');
        Schema::dropIfExists('villages');
    }
}

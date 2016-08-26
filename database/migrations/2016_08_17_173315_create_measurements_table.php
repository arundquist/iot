<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id');
        //    $table->foreign('machine_id')->references('id')->on('machines');
            $table->integer('probe_id');
        //    $table->foreign('probe_id')->references('id')->on('probes');
            $table->integer('location_id');
        //    $table->foreign('location_id')->references('id')->on('locations');
            $table->double('measurement');
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
        Schema::drop('measurements');
    }
}

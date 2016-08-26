<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachineProbePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_probe', function (Blueprint $table) {
            $table->integer('machine_id')->unsigned()->index();
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
            $table->integer('probe_id')->unsigned()->index();
            $table->foreign('probe_id')->references('id')->on('probes')->onDelete('cascade');
            $table->primary(['machine_id', 'probe_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('machine_probe');
    }
}

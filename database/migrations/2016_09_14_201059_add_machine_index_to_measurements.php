<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMachineIndexToMeasurements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('measurements', function (Blueprint $table) {
            $table->index('machine_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('measurements', function (Blueprint $table) {
            $table->dropIndex('measurments_machine_id_index');
          });
    }
}

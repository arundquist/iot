<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherIndicesToMeasurements extends Migration
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
            $table->index('location_id');
            $table->index('probe_id');
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
            $table->dropIndex('measurments_location_id_index');
            $table->dropIndex('measurments_probe_id_index');
          });
    }
}

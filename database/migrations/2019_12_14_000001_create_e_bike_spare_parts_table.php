<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEBikeSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_bike_spare_part', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('e_bike_id');
            $table->unsignedBigInteger('spare_part_id');
            $table->foreign('e_bike_id')->references('id')->on('e_bikes');
            $table->foreign('spare_part_id')->references('id')->on('spare_parts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spare_parts');
    }
}

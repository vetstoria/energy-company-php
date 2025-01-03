<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricityReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electricity_readings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('reading', 10, 8);
            $table->dateTime('time');
            $table->unsignedBigInteger('smart_meter_id');
            $table->foreign('smart_meter_id')->references('id')->on('smart_meters');
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
        Schema::dropIfExists('electricity_readings');
    }
}

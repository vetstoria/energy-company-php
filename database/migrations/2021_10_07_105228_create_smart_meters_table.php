<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smart_meters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('smartMeterId');
            $table->unsignedBigInteger('price_plan_id');
            $table->foreign('price_plan_id')->references('id')->on('price_plans');
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
        Schema::dropIfExists('smart_meters');
    }
}

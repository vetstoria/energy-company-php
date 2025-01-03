<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeaktimeMultipliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peaktime_multipliers', function (Blueprint $table) {
            $table->id();
            $table->date('dayofWeek');
            $table->decimal('multiplier', 10, 8);
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
        Schema::dropIfExists('peaktime_multipliers');
    }
}

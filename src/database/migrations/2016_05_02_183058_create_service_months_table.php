<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_months', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('client_id')->unsigned();
            $table->date('start_date');
            $table->integer('hours_used')->nullable();
            $table->integer('service_plan_id')->unsigned();
            $table->longText('description');
        });
        Schema::table('service_months', function (Blueprint $table) {
            $table->foreign('service_plan_id')->references('id')->on('service_plans')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_months');
    }
}

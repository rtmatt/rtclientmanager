<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivedPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('client_id')->unsigned();
            $table->integer('hours_available_year');
            $table->integer('hours_available_month');
            $table->integer('standard_rate');
            $table->date('start_date');
            $table->dateTime('last_backup_datetime')->nullable();
            $table->longText('service_history');
        });
        Schema::table('archived_plans', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('archived_plans');
    }
}

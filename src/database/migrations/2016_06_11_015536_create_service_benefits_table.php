<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_benefits', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('service_plan_id')->unsigned();
            $table->string('icon');
            $table->string('name');
            $table->mediumText('description');
        });
        Schema::table('service_benefits',function(Blueprint $table){
            $table->foreign('service_plan_id')->references('id')->on('service_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_benefits');
    }
}

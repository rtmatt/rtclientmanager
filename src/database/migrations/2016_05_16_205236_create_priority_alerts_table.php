<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePriorityAlertsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priority_alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->longText("actual");
            $table->longText("expected");
            $table->string("frequency");
            $table->string("user_device")->nullable();
            $table->string("user_browser")->nullable();
            $table->string("user_browser_ver")->nullable();
            $table->string("contact_name")->nullable();
            $table->string("contact_email")->nullable();
            $table->string("contact_phone")->nullable();
            $table->string("additional_info")->nullable();
            $table->longText("attachment")->nullable();
            $table->integer('client_id')->unsigned()->nullable();
        });
        Schema::table('priority_alerts',function(Blueprint $table){
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
        Schema::drop('priority_alerts');
    }
}

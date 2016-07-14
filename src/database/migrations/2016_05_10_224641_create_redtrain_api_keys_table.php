<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedtrainApiKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redtrain_api_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('client_id')->unsigned();
            $table->string('api_secret_key')->unique();
            $table->string('api_name')->unique()    ;
        });
        Schema::table('redtrain_api_keys', function (Blueprint $table) {
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
        Schema::drop('redtrain_api_keys');
    }
}

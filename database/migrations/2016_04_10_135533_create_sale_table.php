<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('appid');
            $table->decimal('price', 4, 2);
            $table->string('desc', 120)->nullable();
            $table->integer('userID');
            $table->smallInteger('active')->default(1); //1 aktywny, 0 nieaktywny
            $table->smallInteger('sold')->default(0); //1 sprzedany, 0 niesprzedany
            $table->string('date', 20);
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
        Schema::drop('sale');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpinionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opinion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('opinion', 250);
            $table->integer('reviewer'); //id osoby ktora wystawia opinię
            $table->integer('userID'); //id osoby, która dostaje opinie
            $table->boolean('what'); //0 - kupił, 1 - sprzedał
            $table->boolean('status'); //0 - nagatyw, 1 - pozytyw
            $table->integer('appid'); //id gry
            $table->string('date', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opinion');
    }
}

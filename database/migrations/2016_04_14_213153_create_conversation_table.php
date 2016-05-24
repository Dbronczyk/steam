<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('key');
            $table->integer('user1'); //pierwsza osoba biorąca udział w rozmowe
            $table->integer('user2'); //druga osoba biorąca udział w rozmowie
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
        Schema::drop('conversation');
    }
}

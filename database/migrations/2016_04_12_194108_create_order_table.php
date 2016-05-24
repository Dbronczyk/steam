<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buyerID');
            $table->integer('sellerID');
            $table->integer('saleID');
            $table->integer('remove')->default(0); // id osoby, ktora chce usunąć zamówienie
            $table->integer('opinion')->default(0); // id osoby, ktora wystawiła już opinię
            $table->string('date', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order');
    }
}

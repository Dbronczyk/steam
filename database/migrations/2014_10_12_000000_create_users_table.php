<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('steamid')->unique();
            $table->string('name',60)->default(0);;
            $table->string('username',60);
            $table->string('avatar');
            $table->string('countryCode',5);
            $table->string('profileURL');
            $table->string('email',60)->default(0);
            //$table->string('password', 60);
            //$table->integer('role',1)->default(0); //0 - user bez akceptacji, 1 - user z akceptacją, 10 - admin
            $table->integer('role')->default(0);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestionesTable extends Migration
{
    public function up()
    {
        Schema::create('gestiones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gestion', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('gestiones');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministradorTable extends Migration
{

    public function up()
    {
        Schema::create('administrador', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id')->unique();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('administrador');
    }
}

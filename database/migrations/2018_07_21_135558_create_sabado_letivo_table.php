<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSabadoLetivoTable extends Migration
{
    public function up()
    {
        Schema::create('sabado_letivo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referente',160);
            $table->date('data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sabado_letivo');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeriadoTable extends Migration
{

    public function up()
    {
        Schema::create('feriado', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('nome',160);
            $table->date('final')->nullable();
            $table->enum('tipo',array(1,2,3)); //1 - feriado, 2 - ferias, 3 - recesso
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feriado');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinaTable extends Migration
{

    public function up()
    {
        Schema::create('disciplina', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',160);
            $table->string('sigla',20);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('disciplina');
    }
}

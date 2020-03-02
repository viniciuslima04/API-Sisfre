<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoTable extends Migration
{
    public function up()
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',160);
            $table->string('sigla',10);
            $table->integer('duracao');
            $table->enum('tipo', array('GRADUAÇÃO', 'TÉCNICO', 'INTEGRADO'));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curso');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptativaTable extends Migration
{

    public function up()
    {
        Schema::create('optativa', function (Blueprint $table) {
            $table->increments('id');
            // Disciplina a ser ofertada
            $table->unsignedInteger('disciplina_id');
            // Turma que recebe a oferta da disciplina
            $table->unsignedInteger('turma_id');
            // Curso que oferta a disciplina
            $table->unsignedInteger('curso_id')->nullable(); 
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('optativa');
    }
}

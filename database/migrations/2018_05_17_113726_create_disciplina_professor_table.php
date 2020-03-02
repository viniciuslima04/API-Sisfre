<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinaProfessorTable extends Migration
{

    public function up()
    {
        Schema::create('disciplina_professor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('disciplina_id');
            $table->unsignedInteger('professor_id');
            $table->unsignedInteger('turma_id');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('disciplina_professor');
    }
}

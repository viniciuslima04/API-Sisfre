<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoDisciplinaTable extends Migration
{

    public function up()
    {
        Schema::create('curso_disciplina', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curso_id');
            $table->unsignedInteger('disciplina_id');
            $table->integer('periodo');
            $table->integer('carga_horaria');
            $table->integer('aula_semanal');
            $table->enum('optativa', array(1,2))->nullable()->default(2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curso_disciplina');
    }
}

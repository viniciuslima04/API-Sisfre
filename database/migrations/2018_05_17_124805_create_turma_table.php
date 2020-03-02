<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmaTable extends Migration
{

    public function up()
    {
        Schema::create('turma', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('descricao');
            $table->integer('periodo');
            $table->enum('turno',array('D','T','M','N'));
            $table->unsignedInteger('semestre_id');
            $table->unsignedInteger('curso_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turma');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaltaTable extends Migration
{

    public function up()
    {
        Schema::create('falta', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dia');
            $table->date('validade');
            $table->integer('qtd');
            $table->longText('obs')->nullable();
            $table->enum('situacao',array('ESP','CONF','NEG','PAGA_P','PAGA_T','VENC'));
            $table->unsignedInteger('funcionario_id');
            $table->unsignedInteger('professor_id');
            $table->unsignedInteger('disciplina_id');
            $table->unsignedInteger('turma_id');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('falta');
    }
}

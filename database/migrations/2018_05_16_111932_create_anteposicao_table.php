<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnteposicaoTable extends Migration
{
    public function up()
    {
        Schema::create('anteposicao', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dia');
            $table->integer('qtd');
            $table->integer('gasta');      
            $table->longText('obs')->nullable();
            $table->enum('situacao',array('ESP','CONF','NEG','VENC'));
            $table->string('arquivo', 160)->nullable();
            $table->unsignedInteger('professor_id');
            $table->unsignedInteger('disciplina_id');
            $table->unsignedInteger('turma_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anteposicao');
    }
}

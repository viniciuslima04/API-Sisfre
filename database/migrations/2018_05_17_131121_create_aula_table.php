<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAulaTable extends Migration
{

    public function up()
    {
        Schema::create('aula', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('dia',array(1,2,3,4,5));
            $table->enum('posicao',array(1,2,3,4,5,6,7,8,9,10,11,12));
            $table->unsignedInteger('disciplina_id');
            $table->unsignedInteger('turma_id');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('aula');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReposicaoTable extends Migration
{

    public function up()
    {
        Schema::create('reposicao', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dia');
            $table->integer('qtd');
            $table->longText('obs')->nullable();
            $table->string('usuario', 20);
            $table->string('arquivo', 160)->nullable();
            $table->enum('situacao',array('ESP','CONF','NEG'));
            $table->unsignedInteger('falta_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reposicao');
    }
}

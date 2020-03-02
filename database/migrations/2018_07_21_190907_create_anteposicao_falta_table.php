<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnteposicaoFaltaTable extends Migration
{

    public function up()
    {
        Schema::create('anteposicao_falta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('anteposicao_id');
            $table->unsignedInteger('falta_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anteposicao_falta');
    }
}

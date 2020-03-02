<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorTable extends Migration
{

    public function up()
    {
        Schema::create('professor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curso_id')->nullable();
            $table->unsignedInteger('usuario_id')->unique();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('professor');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemestreTable extends Migration
{

    public function up()
    {
        Schema::create('semestre', function (Blueprint $table) {
            $table->increments('id');
            $table->year('ano');
            $table->enum('etapa',array(1,2));
            $table->enum('tipo',array('CONVENCIONAL','REGULAR'));
            $table->enum('status',array(1,2));
            $table->date('inicio'); // Inicio do semestre
            $table->date('metade'); // Metade do semestre ou inico da N2
            $table->date('fim'); // fim do semestre
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('semestre');
    }
}

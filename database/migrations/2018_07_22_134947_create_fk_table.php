<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFkTable extends Migration
{

    public function up()
    {
        Schema::table('professor', function ($table) {
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
        });

        Schema::table('administrador', function ($table) {
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
        });

        Schema::table('funcionario', function ($table) {
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
        });

        Schema::table('disciplina_professor', function ($table) {
            $table->foreign('disciplina_id')->references('id')->on('disciplina')->onDelete('cascade');
            $table->foreign('professor_id')->references('id')->on('professor')->onDelete('cascade');
        });

        Schema::table('falta', function ($table) {
            $table->foreign('professor_id')->references('id')->on('professor')->onDelete('cascade');
            $table->foreign('disciplina_id')->references('id')->on('disciplina')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turma')->onDelete('cascade');
            $table->foreign('funcionario_id')->references('id')->on('funcionario')->onDelete('cascade');
        });

        Schema::table('curso_disciplina', function ($table) {
            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
            $table->foreign('disciplina_id')->references('id')->on('disciplina')->onDelete('cascade');
        });

        Schema::table('turma', function ($table) {
            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
            $table->foreign('semestre_id')->references('id')->on('semestre')->onDelete('cascade');
        });

         Schema::table('aula', function ($table) {
            $table->foreign('disciplina_id')->references('id')->on('disciplina')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turma')->onDelete('cascade');
        });

        Schema::table('reposicao', function ($table) {
            $table->foreign('falta_id')->references('id')->on('falta')->onDelete('cascade');
        });

        Schema::table('anteposicao', function ($table) {
            $table->foreign('professor_id')->references('id')->on('professor')->onDelete('cascade');
            $table->foreign('disciplina_id')->references('id')->on('disciplina')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turma')->onDelete('cascade');
        });

        Schema::table('anteposicao_falta', function ($table) {
            $table->foreign('anteposicao_id')->references('id')->on('anteposicao')->onDelete('cascade');
            $table->foreign('falta_id')->references('id')->on('falta')->onDelete('cascade');
        });

        Schema::table('optativa', function ($table) {
            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
            $table->foreign('disciplina_id')->references('id')->on('disciplina')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turma')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fk');
    }
}

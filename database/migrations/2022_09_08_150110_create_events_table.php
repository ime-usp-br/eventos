<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string("titulo", 192);
            $table->unsignedInteger("cadastradorID");
            $table->string("dataInicial");
            $table->string("dataFinal")->nullable();
            $table->string("horarioInicial");
            $table->string("horarioFinal")->nullable();
            $table->string("localID");
            $table->boolean("exigeInscricao")->default(0);
            $table->boolean("gratuito")->default(0);
            $table->boolean("emiteCertificado")->default(0);
            $table->string("idiomaID");
            $table->string("url")->nullable();
            $table->string("nomeOrganizador");
            $table->string("descricao", 8192);
            $table->boolean("aprovado")->default(0);
            $table->unsignedInteger("moderadorID")->nullable();
            $table->string("dataAprovacao")->nullable();
            $table->unsignedInteger("modalidadeID");
            $table->unsignedInteger("tipoID");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}

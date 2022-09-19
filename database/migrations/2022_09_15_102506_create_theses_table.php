<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theses', function (Blueprint $table) {
            $table->id();
            $table->string("titulo", 2048);
            $table->text("resumo", 8192)->nullable();
            $table->string("palavrasChave", 2048)->nullable();
            $table->string("title", 2048)->nullable();
            $table->text("abstract", 8192)->nullable();
            $table->string("keyWords", 2048)->nullable();
            $table->unsignedInteger("alunoID");
            $table->unsignedInteger("defesaID");
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
        Schema::dropIfExists('theses');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("eventoID");
            $table->string("fullName");
            $table->string("nickname");
            $table->string("email");
            $table->string("passport")->nullable();
            $table->string("rg")->nullable();
            $table->string("phone");
            $table->string("affiliation");
            $table->string("position");
            $table->string("department");
            $table->string("cep");
            $table->string("address");
            $table->string("city");
            $table->string("state");
            $table->string("country");
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
        Schema::dropIfExists('registrations');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Criar tabela cliente
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('profissao');
            $table->string('genero');
            $table->string('foto_path')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });

        // Criar tabela documentos
        Schema::create('documentos',function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->unsignedInteger('cliente_id')->primary();
            $table->foreign('cliente_id')
                ->references('id')
                ->on('cliente')
                ->onDelete('cascade');

            $table->string('cpf_path')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg_path')->nullable();
            $table->string('rg')->nullable();
            $table->timestamps();
        });

        // Criar tabela endereço
        Schema::create('enderecos',function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')
                ->references('id')
                ->on('cliente')
                ->onDelete('cascade');

            $table->string('rua');
            $table->integer('numero');
            $table->string('complemento');
            $table->string('cep');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');                    
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
        Schema::dropIfExists('clientes');
    }
}

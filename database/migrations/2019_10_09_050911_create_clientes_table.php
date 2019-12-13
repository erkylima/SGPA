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
            $table->string('chave_acesso');            
            $table->string('email');
            $table->string('nome');
            $table->string('apelido');
            $table->string('profissao');
            $table->string('estado_civil');
            $table->date('nascimento');
            $table->string('nome_mae');
            $table->string('telefone1');
            $table->boolean('whatstelefone1');
            $table->string('telefone2');
            $table->boolean('whatstelefone2');
            $table->boolean('incapaz');
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('orgao')->nullable();
            $table->string('nomeresp')->nullable();
            $table->string('cpfresp')->nullable();
            $table->string('rgresp')->nullable();
            $table->string('orgaoresp')->nullable();
            $table->string('foto_path')->nullable();
            $table->string('nome_recado')->nullable(); 
            $table->tinyInteger('status');
            $table->timestamps();
        });


        // Criar tabela endereço
        Schema::create('enderecos',function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->unsignedInteger('cliente_id')->primary();
            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade');

            $table->string('rua');
            $table->integer('numero');
            $table->string('complemento');
            $table->string('cep');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
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

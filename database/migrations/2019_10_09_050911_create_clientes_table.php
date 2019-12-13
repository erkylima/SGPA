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
            $table->string('chave_acesso')->nullable();
            $table->string('email')->nullable();
            $table->string('nome')->nullable();
            $table->string('apelido')->nullable();
            $table->string('profissao')->nullable();
            $table->string('estado_civil')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('telefone1')->nullable();
            $table->boolean('whatstelefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->boolean('whatstelefone2')->nullable();
            $table->boolean('incapaz')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('orgao')->nullable();
            $table->string('nomeresp')->nullable();
            $table->string('cpfresp')->nullable();
            $table->string('rgresp')->nullable();
            $table->string('orgaoresp')->nullable();
            $table->string('senhainss')->nullable();
            $table->string('foto_path')->nullable();
            $table->string('nome_recado')->nullable();
            $table->string('recado_telefone')->nullable();
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

            $table->string('rua')->nullable();
            $table->integer('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cep')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
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

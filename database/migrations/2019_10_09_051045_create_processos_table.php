<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('descricao');
            $table->tinyInteger('agenciador_id');
            $table->foreign('agenciador_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->double('valor');
            $table->timestamps();
        });        

        Schema::create('cliente_has_processo', function (Blueprint $table) {
            $table->unsignedInteger('cliente_id');
            $table->unsignedBigInteger('processo_id');
            $table->index('cliente_id');

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade');
            
            $table->foreign('processo_id')
            ->references('id')
            ->on('processos')
            ->onDelete('cascade');

            $table->primary(['cliente_id', 'processo_id']);
        });

        Schema::create('audiencia', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('processo_id');
            $table->string('endereco');
            $table->dateTime('data_audiencia');
            
            $table->foreign('processo_id')
            ->references('id')
            ->on('processos')
            ->onDelete('cascade');

        });

        Schema::create('processo_administrativo', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('processo_id');
            $table->string('endereco');
            $table->dateTime('data_pericia');            
            $table->foreign('processo_id')
            ->references('id')
            ->on('processos')
            ->onDelete('cascade');

        });

        Schema::create('processo_salario_maternidade', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('processo_id');
            $table->string('nome_crianca');
            $table->dateTime('data_parto');            
            $table->foreign('processo_id')
            ->references('id')
            ->on('processos')
            ->onDelete('cascade');

        });

        Schema::create('processo_judicial', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('processo_id');
            $table->integer('numero_beneficio');
            $table->dateTime('der');
            $table->bigInteger('valor_causa');
            $table->foreign('processo_id')
            ->references('id')
            ->on('processos')
            ->onDelete('cascade');

        });
        
        Schema::create('cid_categoria', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->string('cod');
            $table->string('descricao');

        });

        Schema::create('cid_subcategoria', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->string('cod');
            $table->string('descricao');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processos');
    }
}

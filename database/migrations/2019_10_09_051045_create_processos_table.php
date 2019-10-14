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
            $table->tinyInteger('agenciador');
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaClienteInvestimento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_investimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cliente')
            ->references('id')
            ->on('clientes')
            ->onDelete('cascade');

            $table->integer('id_investimento')
            ->references('id')
            ->on('tipo_investimentos')
            ->onDelete('cascade');
       
            $table->float('valor_investido');
       
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
        Schema::drop('cliente_investimentos');
    }
}

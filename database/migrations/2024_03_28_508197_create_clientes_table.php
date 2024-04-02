<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('NRODOCUMENTO', 12)->primary();
            $table->string('TIPODOCUMENTO', 2)->nullable();
            $table->string('LINK', 36)->nullable();
            $table->string('RAZONNOMBRE', 255)->nullable();
            $table->smallInteger('DIASCREDITO')->nullable();
            $table->decimal('LIMITECREDITO', 16, 6)->nullable();
            $table->string('EMAIL', 64)->nullable();
            $table->string('TELEFONO', 48)->nullable();
            $table->string('CONTACTO', 64)->nullable();
            $table->string('CLAVEWEB', 16)->nullable();
            $table->string('TIPOCLIENTE', 64)->nullable();
            $table->smallInteger('TIPOORIGEN')->nullable();
            $table->date('FECHANACIMIENTO')->nullable();
            $table->string('OCUPACION', 128)->nullable();
            $table->string('DIRECCION', 250)->nullable();
            $table->string('REFERENCIA', 250)->nullable();
            $table->string('DNIFAMILIAR', 12)->nullable();
            $table->string('TELEFONOCONTACTO', 16)->nullable();
            $table->date('FECULTIMACOMPRA')->nullable();
            $table->string('DOCULTIMACOMPRA', 18)->nullable();
            $table->decimal('PORCENTAJE_DESCUENTO', 16, 2)->nullable();
            $table->decimal('PORCENTAJE_MORA', 16, 2)->nullable();

            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}

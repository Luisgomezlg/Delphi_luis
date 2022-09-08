<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabezafacturas', function (Blueprint $table) {
            $table->id();
            $table->string('factura_id');
            $table->string('cab_fecha');
            $table->string('cliente_id');
            $table->string('cab_total');
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
        Schema::dropIfExists('cabezafacturas');
    }
};

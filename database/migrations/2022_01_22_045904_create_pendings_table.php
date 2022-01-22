<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->text('products')->nullable();
            $table->float('total_sin_impuesto')->nullable();
            $table->float('total_de_impuesto')->nullable();
            $table->float('total_a_pagar')->nullable();
            // $table->integer('factura_generada');
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
        Schema::dropIfExists('pendings');
    }
}

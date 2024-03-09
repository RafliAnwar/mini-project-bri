<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailpesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailpesanan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pesanan')->unsigned();
            $table->foreign('id_pesanan')->references('id')->on('pesanan');
            $table->bigInteger('id_product')->unsigned();
            $table->foreign('id_product')->references('id')->on('product');
            $table->integer('qty');
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
        Schema::dropIfExists('detailpesanan');
    }
}

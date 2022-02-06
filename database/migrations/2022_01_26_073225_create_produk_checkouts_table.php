<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_checkouts', function (Blueprint $table) {
            $table->id();
            $table->integer('idproduk');
            $table->string('nama');
            $table->string('nomorwa');
            $table->string('foto');
            $table->string('deskripsi');
            $table->bigInteger('harga');
            $table->integer('jumlah');
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
        Schema::dropIfExists('produk_checkouts');
    }
}

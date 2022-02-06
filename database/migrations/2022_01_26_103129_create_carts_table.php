<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('idusers');
            $table->integer('idproduk');
            $table->string('nomorpesanan')->nullable();
            $table->string('nama');
            $table->string('foto');
            $table->string('deskripsi');
            $table->bigInteger('harga');
            $table->bigInteger('totalharga');
            $table->integer('jumlah');
            $table->boolean('status');
            $table->boolean('pickcart');
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
        Schema::dropIfExists('carts');
    }
}

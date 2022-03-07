<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto');
            $table->text('deskripsi');
            $table->integer('stok');
            $table->integer('mingrosir');
            $table->integer('maxgrosir');
            $table->bigInteger('harga');
            $table->bigInteger('hargagrosir')->nullable();
            $table->float('rating')->nullable();
            $table->enum('kategori',['Thinner B Special','Thinner A','Thinner A Special','Spiritus','Rockstar','Produk Lainnya'])->nullable();
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
        Schema::dropIfExists('produks');
    }
}

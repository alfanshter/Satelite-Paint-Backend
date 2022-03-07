<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cicilans', function 
        (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon');
            $table->string('alamat');
            $table->string('nomorpesanan');
            $table->string('metodepembayaran');
            $table->bigInteger('totalharga');
            $table->bigInteger('diskon')->default(0);
            $table->date('tanggal');
            $table->time('jam');
            $table->integer('status');
            $table->date('jatuhtempo1');
            $table->date('jatuhtempo2');
            $table->date('jatuhtempo3');
            $table->date('jatuhtempo4');
            $table->integer('statuscicilan');
            $table->integer('hargacicilan');
            $table->integer('jumlahcicilan');
            $table->string('idusers');
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('cicilans');
    }
}

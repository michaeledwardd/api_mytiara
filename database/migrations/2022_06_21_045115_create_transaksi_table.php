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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id_transaksi')->primary();
            $table->string('id_barang')->index();
            $table->unsignedBigInteger('id_pegawai')->index();
            $table->unsignedBigInteger('id_customer')->index();
            $table->double('quantity');
            $table->double('total_quantity');
            $table->double('total_all');
            $table->string('metode_bayar');
            $table->string('status_transaksi');
            $table->date('tgl_transaksi');
            $table->timestamps();
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai');
            $table->foreign('id_customer')->references('id_customer')->on('customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};

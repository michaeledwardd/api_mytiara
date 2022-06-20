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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('id_barang')->primary();
            $table->unsignedBigInteger('id_jenis')->index();
            $table->string('nama_barang');
            $table->double('harga_pokok');
            $table->double('harga_jual');
            $table->string('status_tersedia');
            $table->string('garansi');
            $table->integer('durasi_garansi');
            $table->string('foto_barang');
            $table->integer('stok_barang');
            $table->string('keterangan');
            $table->timestamps();
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
};

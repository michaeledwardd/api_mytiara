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
        Schema::create('returan', function (Blueprint $table) {
            $table->id('id_returan');
            $table->unsignedBigInteger('id_barang')->index();
            $table->string('kendala_barang');
            $table->string('status_returan');
            $table->date('tgl_diambil');
            $table->timestamps();
            $table->foreign('id_barang')->references('id_barang')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returans');
    }
};

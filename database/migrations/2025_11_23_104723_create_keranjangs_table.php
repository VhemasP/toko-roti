<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            // Gunakan bigIncrements untuk ID (standar Laravel)
            $table->id('id_keranjang'); 
            $table->string('kode_customer', 100);
            $table->string('kode_produk', 100);
            $table->string('nama_produk', 100);
            $table->integer('qty');
            $table->integer('harga');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keranjangs');
    }
};
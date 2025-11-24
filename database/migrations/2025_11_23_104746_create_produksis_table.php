<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produksis', function (Blueprint $table) {
            $table->id('id_order'); // Primary key auto increment
            $table->string('invoice', 200);
            $table->string('kode_customer', 200);
            $table->string('kode_produk', 200);
            $table->string('nama_produk', 200);
            $table->integer('qty');
            $table->integer('harga');
            $table->string('status', 200);
            $table->date('tanggal');
            
            // Kolom alamat pengiriman
            $table->string('provinsi', 200);
            $table->string('kota', 200);
            $table->string('alamat', 200);
            $table->string('kode_pos', 200);
            
            // Kolom status terima/tolak/cek
            $table->string('terima', 200)->default('0');
            $table->string('tolak', 200)->default('0');
            $table->integer('cek')->default(0);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produksis');
    }
};
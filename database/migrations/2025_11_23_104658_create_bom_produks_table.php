<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bom_produks', function (Blueprint $table) {
            // Tabel ini tidak memiliki primary key tunggal di SQL asli,
            // tapi kita tambahkan ID default Laravel agar lebih rapi.
            $table->id(); 
            $table->string('kode_bom', 100);
            $table->string('kode_bk', 100);
            $table->string('kode_produk', 100);
            $table->string('nama_produk', 200);
            $table->string('kebutuhan', 200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bom_produks');
    }
};
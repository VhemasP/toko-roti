<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            // Primary key string (M0001, dll)
            $table->string('kode_bk', 100)->primary();
            $table->string('nama', 200);
            $table->string('qty', 200); // Sesuai SQL asli (varchar)
            $table->string('satuan', 200);
            $table->integer('harga');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
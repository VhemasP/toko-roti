<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            // Primary key string (C0001, dll)
            $table->string('kode_customer', 100)->primary();
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->string('username', 100);
            $table->string('password', 100);
            $table->string('telp', 200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
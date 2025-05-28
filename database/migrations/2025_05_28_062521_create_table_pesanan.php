<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('kode_pesanan')->unique()->primary();
            $table->timestamp('tanggal')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
        });

        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail_pesanan');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->unsignedBigInteger('id_barang');
            $table->string('kode_pesanan');
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('kode_pesanan')->references('kode_pesanan')->on('pesanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
    }
};

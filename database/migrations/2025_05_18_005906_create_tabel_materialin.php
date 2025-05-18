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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('nama_barang', 50);
            $table->string('kategori', 50);
            $table->integer('stok');
            $table->string('satuan', 10);
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });

        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->string('nama_karyawan', 50);
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('no_telpon', 15);
            $table->string('alamat', 100);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama_pelanggan', 50);
            $table->string('no_telpon', 15);
            $table->string('alamat', 100);
            $table->timestamps();
        });

        Schema::create('pemasok', function (Blueprint $table) {
            $table->id('id_pemasok');
            $table->string('nama_pemasok', 50);
            $table->string('no_telpon', 15);
            $table->string('alamat', 100);
            $table->timestamps();
        });

        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            // $table->timestamp('tanggal')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
        });

        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail_pesanan');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_pesanan');
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan');
        });

        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');
            // $table->timestamp('tanggal')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->unsignedBigInteger('id_pemasok');
            $table->unsignedBigInteger('id_karyawan');
            $table->timestamps();

            $table->foreign('id_pemasok')->references('id_pemasok')->on('pemasok');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('pemasok');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('karyawan');
        Schema::dropIfExists('barang');
    }
};

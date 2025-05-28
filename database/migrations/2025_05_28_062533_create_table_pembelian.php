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
            Schema::create('pembelian', function (Blueprint $table) {
            $table->string('kode_pembelian')->unique()->primary();
            $table->timestamp('tanggal')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->unsignedBigInteger('id_pemasok');
            $table->timestamps();

            $table->foreign('id_pemasok')->references('id_pemasok')->on('pemasok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};

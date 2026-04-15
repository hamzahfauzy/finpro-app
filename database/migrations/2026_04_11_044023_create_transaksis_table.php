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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_perusahaan')
                ->constrained('perusahaan')
                ->cascadeOnDelete();

            $table->foreignId('id_rekening')
                ->constrained('rekening')
                ->cascadeOnDelete();

            $table->foreignId('id_paket')
                ->nullable()
                ->constrained('paket')
                ->nullOnDelete();

            $table->enum('tipe_transaksi', ['masuk', 'keluar']);

            $table->string('kategori')->nullable();

            $table->bigInteger('jumlah');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');

            $table->enum('tipe_arus', ['kas', 'paket']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

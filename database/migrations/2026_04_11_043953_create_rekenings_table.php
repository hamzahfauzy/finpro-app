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
        Schema::create('rekening', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_perusahaan')
                ->constrained('perusahaan')
                ->cascadeOnDelete();

            $table->string('nama');
            $table->enum('tipe', ['escrow', 'giro','induk']);
            $table->bigInteger('saldo')->default(0);
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_rekening')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening');
    }
};

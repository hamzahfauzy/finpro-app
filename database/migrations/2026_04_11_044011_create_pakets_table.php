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
        Schema::create('paket', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_perusahaan')
                ->constrained('perusahaan')
                ->cascadeOnDelete();

            $table->foreignId('id_kategori')
                ->constrained('kategori_paket')
                ->cascadeOnDelete();

            $table->string('nama');

            $table->string('nama_ringkas');
            $table->decimal('nilai_proyek', 15, 2)->default(0);
            $table->decimal('anggaran', 15, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};

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
        Schema::create('modal', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_paket')
                ->constrained('paket')
                ->cascadeOnDelete();

            $table->bigInteger('jumlah');
            $table->string('tipe'); // bisa kamu enum kalau sudah fix

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modal');
    }
};

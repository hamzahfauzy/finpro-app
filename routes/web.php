<?php

use App\Http\Controllers\KategoriPaketController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/api/options', [OptionController::class, 'get']);

Route::middleware('auth')->group(function () {
    Route::middleware('verified')->group(function() {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('perusahaan', PerusahaanController::class);
        Route::resource('rekening', RekeningController::class);
        Route::resource('kategori', KategoriPaketController::class);
        Route::resource('paket', PaketController::class);
        Route::resource('modal', ModalController::class);

        Route::prefix('transaksi')->name('transaksi.')->group(function(){
            Route::get('kmk', [TransaksiController::class, 'kmk'])->name('kmk');
            Route::get('transfer', [TransaksiController::class, 'transfer'])->name('transfer');
            Route::get('modal', [TransaksiController::class, 'modal'])->name('modal');
            Route::get('pendapatan', [TransaksiController::class, 'pendapatan'])->name('pendapatan');
            Route::get('kewajiban', [TransaksiController::class, 'kewajiban'])->name('kewajiban');

            Route::post('save', [TransaksiController::class, 'save'])->name('save');
            Route::put('update', [TransaksiController::class, 'update'])->name('update');
        });

        Route::resource('transaksi', TransaksiController::class);

        Route::prefix('laporan')->name('laporan.')->group(function(){
            Route::get('index', [LaporanController::class, 'index'])->name('index');
            Route::get('saldo-perusahaan', [LaporanController::class, 'saldoPerusahaan'])->name('saldo-perusahaan');
            Route::get('saldo-kegiatan', [LaporanController::class, 'saldoKegiatan'])->name('saldo-kegiatan');
            Route::get('laporan-kegiatan', [LaporanController::class, 'laporanKegiatan'])->name('laporan-kegiatan');
            Route::get('buku-besar/{id}', [LaporanController::class, 'bukuBesar'])->name('buku-besar');
        });
        
    });


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

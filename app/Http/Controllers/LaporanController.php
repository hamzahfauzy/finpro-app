<?php

namespace App\Http\Controllers;

use App\Services\FinanceService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //

    function index(FinanceService $finance){
        $data = $finance->saldoPerRekening([
            'tanggal_awal' => '2026-01-01',
            'tanggal_akhir' => '2026-12-31',
        ]);

        return view('laporan.index', compact('data'));
    }
    
    function saldoPerusahaan(FinanceService $finance){
        $data = $finance->saldoPerPerusahaan([
            'tanggal_awal' => '2026-01-01',
            'tanggal_akhir' => '2026-12-31',
        ]);

        return $data;

        return view('laporan.saldo-perusahaan', compact('data'));
    }
    
    function saldoKegiatan(FinanceService $finance){
        $data = $finance->saldoPerKegiatan([
            'tanggal_awal' => '2026-01-01',
            'tanggal_akhir' => '2026-12-31',
        ]);

        return $data;

        return view('laporan.saldo-kegiatan', compact('data'));
    }
    
    function laporanKegiatan(FinanceService $finance){
        $data = $finance->laporanKegiatan([
            'tanggal_awal' => '2026-01-01',
            'tanggal_akhir' => '2026-12-31',
        ]);

        return $data;

        return view('laporan.laporan-kegiatan', compact('data'));
    }
    
    function bukuBesar($id, FinanceService $finance){
        $data = $finance->bukuBesarRekening($id);

        return $data;

        return view('laporan.buku-besar', compact('data'));
    }
}

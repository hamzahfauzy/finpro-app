<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Transaksi;
use App\Services\FinanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    function kasInduk()
    {
        $rekening = Rekening::where('tipe', 'induk')->get();

        $data = [];

        $grand = [
            'masuk' => array_fill(1, 12, 0),
            'keluar' => array_fill(1, 12, 0),
            'saldo' => array_fill(1, 12, 0),
        ];

        foreach ($rekening as $rek) {

            // ambil transaksi per bulan
            $transaksi = Transaksi::
                select(
                    DB::raw('MONTH(tanggal) as bulan'),
                    DB::raw('SUM(CASE WHEN tipe_transaksi = "masuk" THEN jumlah ELSE 0 END) as masuk'),
                    DB::raw('SUM(CASE WHEN tipe_transaksi = "keluar" THEN jumlah ELSE 0 END) as keluar')
                )
                ->where('id_rekening', $rek->id)
                ->where('kategori', '<>', 'kewajiban')
                ->groupBy('bulan')
                ->get()
                ->keyBy('bulan');

            $result = [
                'nama' => $rek->nama,
                'rekening' => $rek->nama_rekening . ' - ' . $rek->nomor_rekening,
                'masuk' => [],
                'keluar' => [],
                'saldo' => [],
                'total_masuk' => 0,
                'total_keluar' => 0,
                'total_saldo' => 0,
            ];

            for ($i = 1; $i <= 12; $i++) {
                $masuk = $transaksi[$i]->masuk ?? 0;
                $keluar = $transaksi[$i]->keluar ?? 0;
                $saldo = $masuk - $keluar;

                $result['masuk'][$i] = $masuk;
                $result['keluar'][$i] = $keluar;
                $result['saldo'][$i] = $saldo;
                
                $result['total_masuk'] += $masuk;
                $result['total_keluar'] += $keluar;
                $result['total_saldo'] += $saldo;

                // total per kolom
                $grand['masuk'][$i] += $masuk;
                $grand['keluar'][$i] += $keluar;
                $grand['saldo'][$i] += $saldo;
            }

            $data[] = $result;
        }

        // grand total akhir
        $grand['total_masuk'] = array_sum($grand['masuk']);
        $grand['total_keluar'] = array_sum($grand['keluar']);
        $grand['total_saldo'] = array_sum($grand['saldo']);

        return view('laporan.kas-induk', compact('data','grand'));
    }

    function kasOperasional()
    {
        $rekening = Rekening::where('tipe', 'giro')->get();

        $data = [];

        $grand = [
            'masuk' => array_fill(1, 12, 0),
            'keluar' => array_fill(1, 12, 0),
            'saldo' => array_fill(1, 12, 0),
        ];

        foreach ($rekening as $rek) {

            // ambil transaksi per bulan
            $transaksi = Transaksi::
                select(
                    DB::raw('MONTH(tanggal) as bulan'),
                    DB::raw('SUM(CASE WHEN tipe_transaksi = "masuk" THEN jumlah ELSE 0 END) as masuk'),
                    DB::raw('SUM(CASE WHEN tipe_transaksi = "keluar" THEN jumlah ELSE 0 END) as keluar')
                )
                ->where('id_rekening', $rek->id)
                ->where('kategori', '<>', 'kewajiban')
                ->groupBy('bulan')
                ->get()
                ->keyBy('bulan');

            $result = [
                'nama' => $rek->nama,
                'rekening' => $rek->nama_rekening . ' - ' . $rek->nomor_rekening,
                'masuk' => [],
                'keluar' => [],
                'saldo' => [],
                'total_masuk' => 0,
                'total_keluar' => 0,
                'total_saldo' => 0,
            ];

            for ($i = 1; $i <= 12; $i++) {
                $masuk = $transaksi[$i]->masuk ?? 0;
                $keluar = $transaksi[$i]->keluar ?? 0;
                $saldo = $masuk - $keluar;

                $result['masuk'][$i] = $masuk;
                $result['keluar'][$i] = $keluar;
                $result['saldo'][$i] = $saldo;
                
                $result['total_masuk'] += $masuk;
                $result['total_keluar'] += $keluar;
                $result['total_saldo'] += $saldo;

                // total per kolom
                $grand['masuk'][$i] += $masuk;
                $grand['keluar'][$i] += $keluar;
                $grand['saldo'][$i] += $saldo;
            }

            $data[] = $result;
        }

        // grand total akhir
        $grand['total_masuk'] = array_sum($grand['masuk']);
        $grand['total_keluar'] = array_sum($grand['keluar']);
        $grand['total_saldo'] = array_sum($grand['saldo']);

        return view('laporan.kas-operasional', compact('data','grand'));
    }

    function cashflow()
    {
        $rekening = Rekening::where('tipe','giro')->pluck('id');
        $raw = DB::table('transaksi as t')
            ->leftJoin('paket as p', 'p.id', '=', 't.id_paket')
            ->leftJoin('kategori_paket as kp', 'kp.id', '=', 'p.id_kategori')
            ->select(
                't.kategori',
                't.tipe_transaksi',
                'kp.id as kategori_id',
                'kp.nama as kategori_nama',
                'p.id as paket_id',
                'p.nama as paket_nama',
                DB::raw('MONTH(t.tanggal) as bulan'),
                DB::raw('SUM(t.jumlah) as total')
            )
            ->groupBy(
                't.kategori',
                't.tipe_transaksi',
                'kp.id',
                'p.id',
                'bulan'
            )
            ->whereNotIn('t.kategori', ['transfer','kmk','kewajiban'])
            ->whereIn('t.id_rekening', $rekening)
            ->whereNull('t.deleted_at')
            ->get();

        $data = [
            'masuk' => ['modal' => [], 'pendapatan' => []],
            'keluar' => ['kewajiban' => []],
        ];

        foreach ($raw as $row) {

            $jenis = $row->tipe_transaksi; // masuk / keluar
            $kategori = $row->kategori; // modal / pendapatan / kewajiban

            if (!isset($data[$jenis][$kategori][$row->kategori_id])) {
                $data[$jenis][$kategori][$row->kategori_id] = [
                    'nama' => $row->kategori_nama,
                    'bulan' => array_fill(1, 12, 0),
                    'paket' => []
                ];
            }

            // kategori level
            $data[$jenis][$kategori][$row->kategori_id]['bulan'][$row->bulan] += $row->total;

            // paket level
            if (!isset($data[$jenis][$kategori][$row->kategori_id]['paket'][$row->paket_id])) {
                $data[$jenis][$kategori][$row->kategori_id]['paket'][$row->paket_id] = [
                    'nama' => $row->paket_nama,
                    'bulan' => array_fill(1, 12, 0),
                ];
            }

            $data[$jenis][$kategori][$row->kategori_id]['paket'][$row->paket_id]['bulan'][$row->bulan] += $row->total;
        }

        $saldo = [];

        foreach ($data['masuk'] as $kategori => $list) {

            foreach ($list as $katId => $kat) {

                // init kategori
                if (!isset($saldo[$kategori])) {
                    $saldo[$kategori] = [];
                }
                
                if (!isset($saldo[$kategori][$katId])) {
                    $saldo[$kategori][$katId] = [
                        'nama' => $kat['nama'],
                        'bulan' => array_fill(1, 12, 0),
                        'paket' => []
                    ];
                }

                // kategori level
                foreach ($kat['bulan'] as $bulan => $val) {
                    $saldo[$kategori][$katId]['bulan'][$bulan] += $val;
                }

                // paket level
                foreach ($kat['paket'] as $paketId => $paket) {

                    if (!isset($saldo[$kategori][$katId]['paket'][$paketId])) {
                        $saldo[$kategori][$katId]['paket'][$paketId] = [
                            'nama' => $paket['nama'],
                            'bulan' => array_fill(1, 12, 0),
                        ];
                    }

                    foreach ($paket['bulan'] as $bulan => $val) {
                        $saldo[$kategori][$katId]['paket'][$paketId]['bulan'][$bulan] += $val;
                    }
                }
            }
        }

        foreach ($data['keluar'] as $kategori => $list) {

            foreach ($list as $katId => $kat) {

                if (!isset($saldo[$kategori])) {
                    $saldo[$kategori] = [];
                }

                if (!isset($saldo[$kategori][$katId])) {
                    $saldo[$kategori][$katId] = [
                        'nama' => $kat['nama'],
                        'bulan' => array_fill(1, 12, 0),
                        'paket' => []
                    ];
                }

                // kategori level
                foreach ($kat['bulan'] as $bulan => $val) {
                    $saldo[$kategori][$katId]['bulan'][$bulan] -= $val;
                }

                // paket level
                foreach ($kat['paket'] as $paketId => $paket) {

                    if (!isset($saldo[$kategori][$katId]['paket'][$paketId])) {
                        $saldo[$kategori][$katId]['paket'][$paketId] = [
                            'nama' => $paket['nama'],
                            'bulan' => array_fill(1, 12, 0),
                        ];
                    }

                    foreach ($paket['bulan'] as $bulan => $val) {
                        $saldo[$kategori][$katId]['paket'][$paketId]['bulan'][$bulan] -= $val;
                    }
                }
            }
        }

        $grandMasuk = [];
        $grandKeluar = [];
        $grandSaldo = [];

        $grandMasuk = [
            'bulan' => array_fill(1, 12, 0),
            'total' => 0
        ];

        foreach ($data['masuk'] as $kategori => $list) {
            foreach ($list as $katId => $kat) {

                foreach ($kat['bulan'] as $bulan => $val) {
                    $grandMasuk['bulan'][$bulan] += $val;
                    $grandMasuk['total'] += $val;
                }
            }
        }

        $grandKeluar = [
            'bulan' => array_fill(1, 12, 0),
            'total' => 0
        ];

        foreach ($data['keluar'] as $kategori => $list) {
            foreach ($list as $katId => $kat) {

                foreach ($kat['bulan'] as $bulan => $val) {
                    $grandKeluar['bulan'][$bulan] += $val;
                    $grandKeluar['total'] += $val;
                }
            }
        }

        $grandSaldo = [
            'bulan' => array_fill(1, 12, 0),
            'total' => 0
        ];

        foreach ($saldo as $kategori => $list) {
            foreach ($list as $katId => $kat) {

                foreach ($kat['bulan'] as $bulan => $val) {
                    $grandSaldo['bulan'][$bulan] += $val;
                    $grandSaldo['total'] += $val;
                }
            }
        }

        return view('laporan.cash-flow', compact('data','saldo','grandMasuk','grandKeluar','grandSaldo'));
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

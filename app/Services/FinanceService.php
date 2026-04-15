<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class FinanceService
{
    /**
     * Base query (biar reusable)
     */
    protected function baseQuery($filters = [])
    {
        $query = DB::table('transaksi')->whereNull('transaksi.deleted_at');

        if (!empty($filters['tanggal_awal'])) {
            $query->whereDate('tanggal', '>=', $filters['tanggal_awal']);
        }

        if (!empty($filters['tanggal_akhir'])) {
            $query->whereDate('tanggal', '<=', $filters['tanggal_akhir']);
        }

        if (!empty($filters['id_perusahaan'])) {
            $query->where('id_perusahaan', $filters['id_perusahaan']);
        }

        return $query;
    }

    /**
     * 🔹 Saldo per rekening
     */
    public function saldoPerRekening($filters = [])
    {
        return $this->baseQuery($filters)
            ->leftJoin('rekening','rekening.id','=','transaksi.id_rekening')
            ->select(
                'id_rekening',
                'rekening.nama',
                'rekening.nama_rekening',
                'rekening.nomor_rekening',
                DB::raw("
                    SUM(
                        CASE 
                            WHEN tipe_transaksi = 'masuk' THEN jumlah
                            WHEN tipe_transaksi = 'keluar' THEN -jumlah
                        END
                    ) as saldo
                ")
            )
            ->groupBy('id_rekening')
            ->get();
    }

    /**
     * 🔹 Saldo per perusahaan
     */
    public function saldoPerPerusahaan($filters = [])
    {
        return $this->baseQuery($filters)
            ->leftJoin('perusahaan','perusahaan.id','=','transaksi.id_perusahaan')
            ->select(
                'id_perusahaan',
                'perusahaan.nama',
                DB::raw("
                    SUM(
                        CASE 
                            WHEN tipe_transaksi = 'masuk' THEN jumlah
                            WHEN tipe_transaksi = 'keluar' THEN -jumlah
                        END
                    ) as saldo
                ")
            )
            ->groupBy('id_perusahaan')
            ->get();
    }

    /**
     * 🔹 Saldo per kegiatan
     */
    public function saldoPerKegiatan($filters = [])
    {
        return $this->baseQuery($filters)
            ->whereNotNull('id_paket')
            ->select(
                'id_paket',
                DB::raw("
                    SUM(
                        CASE 
                            WHEN kategori = 'modal' THEN jumlah
                            WHEN tipe_transaksi = 'masuk' THEN jumlah
                            WHEN tipe_transaksi = 'keluar' THEN -jumlah
                        END
                    ) as saldo
                ")
            )
            ->groupBy('id_paket')
            ->get();
    }

    /**
     * 🔥 Detail kegiatan (modal, income, expense, saldo)
     */
    public function laporanKegiatan($filters = [])
    {
        return $this->baseQuery($filters)
            ->whereNotNull('id_paket')
            ->select(
                'id_paket',
                DB::raw("SUM(CASE WHEN kategori = 'modal' THEN jumlah ELSE 0 END) as modal"),
                DB::raw("SUM(CASE WHEN kategori != 'modal' AND tipe_transaksi = 'masuk' THEN jumlah ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN tipe_transaksi = 'keluar' THEN jumlah ELSE 0 END) as expense"),
                DB::raw("
                    SUM(
                        CASE 
                            WHEN kategori = 'modal' THEN jumlah
                            WHEN tipe_transaksi = 'masuk' THEN jumlah
                            WHEN tipe_transaksi = 'keluar' THEN -jumlah
                        END
                    ) as saldo
                ")
            )
            ->groupBy('id_paket')
            ->get();
    }

    public function bukuBesarRekening($idRekening, $filters = [])
    {
        $query = $this->baseQuery($filters)
            ->where('transaksi.id_rekening', $idRekening)
            ->select(
                'transaksi.id',
                'tanggal',
                'deskripsi',
                'kategori',
                'tipe_transaksi',
                'jumlah'
            )
            ->orderBy('tanggal', 'asc')
            ->orderBy('transaksi.id', 'asc');

        $data = $query->get();

        $saldo = 0;

        // Hitung saldo berjalan
        $result = $data->map(function ($item) use (&$saldo) {

            $nilai = 0;

            // 🔥 LOGIC UTAMA (ANTI DOUBLE TRANSFER)
            if ($item->kategori === 'modal') {
                $nilai = $item->jumlah;
            } elseif ($item->kategori === 'transfer') {
                // transfer tetap mempengaruhi rekening
                $nilai = $item->tipe_transaksi === 'masuk'
                    ? $item->jumlah
                    : -$item->jumlah;
            } else {
                $nilai = $item->tipe_transaksi === 'masuk'
                    ? $item->jumlah
                    : -$item->jumlah;
            }

            $saldo += $nilai;

            $item->debit = $item->tipe_transaksi === 'masuk' ? $item->jumlah : 0;
            $item->kredit = $item->tipe_transaksi === 'keluar' ? $item->jumlah : 0;
            $item->saldo = $saldo;

            return $item;
        });

        return $result;
    }
}
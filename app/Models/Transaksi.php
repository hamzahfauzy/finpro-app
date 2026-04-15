<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    //
    use SoftDeletes;
    protected $table = 'transaksi';
    protected $guarded = [];

    public $fields = [
        'id_perusahaan' => [
            'label' => 'Perusahaan',
            'type' => 'select',
            'relation' => \App\Models\Perusahaan::class,
            'display' => 'nama'
        ],
        'id_rekening' => [
            'label' => 'Rekening',
            'type' => 'select',
            'relation' => \App\Models\Rekening::class,
            'display' => 'nama',
            'depends_on' => 'id_perusahaan', // 🔥 kunci
            'foreign_key' => 'id_perusahaan'
        ],
        'id_paket' => [
            'label' => 'Paket',
            'type' => 'select',
            'relation' => \App\Models\Paket::class,
            'display' => 'nama',
            'depends_on' => 'id_perusahaan',
            'foreign_key' => 'id_perusahaan'
        ],
        'tipe_transaksi' => [
            'label' => 'Tipe Transaksi',
            'type' => 'select',
            'options' => [
                'masuk' => 'Masuk',
                'keluar' => 'Keluar'
            ]
        ],
        'kategori' => [
            'label' => 'Kategori',
            'type' => 'select',
            'options' => [
                'modal' => 'Modal',
                'kewajiban' => 'Kewajiban',
                'pendapatan' => 'Pendapatan',
                'transfer' => 'Transfer',
                'kmk' => 'KMK',
            ]
        ],
        'jumlah' => [
            'label' => 'Jumlah',
            'type' => 'number'
        ],
        'deskripsi' => [
            'label' => 'Deskripsi',
            'type' => 'textarea'
        ],
        'tanggal' => [
            'label' => 'Tanggal',
            'type' => 'date'
        ],
        'tipe_arus' => [
            'label' => 'Tipe Arus',
            'type' => 'select',
            'options' => [
                'kas' => 'Kas',
                'paket' => 'Paket'
            ]
        ],
    ];

    public $listColumns = [
        'tanggal' => 'Tanggal',
        'perusahaan.nama' => 'Perusahaan',
        'rekening.nama' => 'Rekening',
        'jumlah' => [
            'label' => 'Jumlah',
            'type' => 'currency'
        ],
        'kategori' => 'Kategori',
        'tipe_transaksi' => 'Tipe',
        'deskripsi' => 'Deskripsi',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}

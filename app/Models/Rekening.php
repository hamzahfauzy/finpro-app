<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekening extends Model
{
    //
    use SoftDeletes;
    protected $table = 'rekening';
    protected $guarded = [];

    public $fields = [
        'id_perusahaan' => [
            'label' => 'Perusahaan',
            'type' => 'select',
            'relation' => \App\Models\Perusahaan::class,
            'display' => 'nama'
        ],
        'nama' => [
            'label' => 'Nama Rekening',
            'type' => 'text'
        ],
        'tipe' => [
            'label' => 'Tipe',
            'type' => 'select',
            'options' => [
                'escrow' => 'Escrow',
                'giro' => 'Giro'
            ]
        ],
        'saldo' => [
            'label' => 'Saldo',
            'type' => 'number'
        ],
        'nomor_rekening' => [
            'label' => 'Nomor Rekening',
            'type' => 'text'
        ],
        'nama_rekening' => [
            'label' => 'Nama Pemilik',
            'type' => 'text'
        ],
    ];

    public $listColumns = [
        'perusahaan.nama' => 'Perusahaan',
        'nama' => 'Nama',
        'nomor_rekening' => 'No. Rekening',
        'nama_rekening' => 'Nama Rekening',
        'tipe' => 'Tipe',
        'saldo' => 'Saldo'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_rekening');
    }
}

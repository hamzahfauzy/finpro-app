<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paket extends Model
{
    //
    use SoftDeletes;
    protected $table = 'paket';
    protected $guarded = [];

    public $fields = [
        'id_perusahaan' => [
            'label' => 'Perusahaan',
            'type' => 'select',
            'relation' => \App\Models\Perusahaan::class,
            'display' => 'nama'
        ],
        'id_kategori' => [
            'label' => 'Kategori',
            'type' => 'select',
            'relation' => \App\Models\KategoriPaket::class,
            'display' => 'nama'
        ],
        'nama' => [
            'label' => 'Nama Paket',
            'type' => 'text'
        ],
        'nama_ringkas' => [
            'label' => 'Nama Ringkas Paket',
            'type' => 'text'
        ],
        'nilai_proyek' => [
            'label' => 'Nilai Proyek',
            'type' => 'number'
        ],
        'anggaran' => [
            'label' => 'Anggaran',
            'type' => 'number'
        ],
    ];

    public $listColumns = [
        'perusahaan.nama' => 'Perusahaan',
        // 'nama' => 'Nama',
        'nama_ringkas' => 'Nama Ringkas',
        'kategori.nama' => 'Kategori',
        'nilai_proyek' => [
            'label' => 'Nilai Proyek',
            'type' => 'currency'
        ],
        'anggaran' => [
            'label' => 'Anggaran',
            'type' => 'currency'
        ],
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPaket::class, 'id_kategori');
    }

    public function modal()
    {
        return $this->hasMany(Modal::class, 'id_paket');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_paket');
    }
}

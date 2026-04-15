<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perusahaan extends Model
{
    //
    use SoftDeletes;
    protected $table = 'perusahaan';
    protected $guarded = [];

    public $fields = [
        'nama' => [
            'label' => 'Nama',
            'type' => 'text'
        ],
        'alamat' => [
            'label' => 'Alamat',
            'type' => 'textarea'
        ],
        'no_hp' => [
            'label' => 'No HP',
            'type' => 'text'
        ],
    ];

    public $listColumns = [
        'nama' => 'Nama',
        'alamat' => 'Alamat',
        'no_hp' => 'No HP'
    ];

    public function rekening()
    {
        return $this->hasMany(Rekening::class, 'id_perusahaan');
    }

    public function paket()
    {
        return $this->hasMany(Paket::class, 'id_perusahaan');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_perusahaan');
    }
}

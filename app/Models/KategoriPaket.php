<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriPaket extends Model
{
    //
    use SoftDeletes;
    protected $table = 'kategori_paket';
    protected $guarded = [];

    public $fields = [
        'nama' => [
            'label' => 'Nama',
            'type' => 'text'
        ]
    ];

    public $listColumns = [
        'nama' => 'Nama'
    ];

    public function paket()
    {
        return $this->hasMany(Paket::class, 'id_kategori');
    }
}

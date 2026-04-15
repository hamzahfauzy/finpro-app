<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modal extends Model
{
    //
    use SoftDeletes;
    protected $table = 'modal';
    protected $guarded = [];

    public $fields = [
        'id_paket' => [
            'label' => 'Paket',
            'type' => 'select',
            'relation' => \App\Models\Paket::class,
            'display' => 'nama'
        ],
        'jumlah' => [
            'label' => 'Jumlah',
            'type' => 'number'
        ],
        'tipe' => [
            'label' => 'Tipe',
            'type' => 'text'
        ],
    ];

    public $listColumns = [
        'id_paket' => 'Paket',
        'jumlah' => 'Jumlah',
        'tipe' => 'Tipe'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}

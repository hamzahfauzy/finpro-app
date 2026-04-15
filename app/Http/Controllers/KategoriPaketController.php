<?php

namespace App\Http\Controllers;

use App\Models\KategoriPaket;

class KategoriPaketController extends BaseCrudController
{
    protected $model = KategoriPaket::class;
    protected $routePrefix = 'kategori.';

    public function pageSetting()
    {
        $parent = parent::pageSetting();

        $parent['listTitle'] = 'Data Kategori';
        $parent['additionalActions'] = [
            [
                'label' => 'Buku Besar',
                'url' => '/laporan/buku-besar-kategori/{id}'
            ]
        ];

        return $parent;
    }
}

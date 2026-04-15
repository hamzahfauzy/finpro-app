<?php

namespace App\Http\Controllers;

use App\Models\Paket;

class PaketController extends BaseCrudController
{
    protected $model = Paket::class;
    protected $routePrefix = 'paket.';

    public function pageSetting()
    {
        $parent = parent::pageSetting();

        $parent['listTitle'] = 'Data Paket';
        $parent['additionalActions'] = [
            [
                'label' => 'Buku Besar',
                'url' => '/laporan/buku-besar-paket/{id}'
            ]
        ];

        return $parent;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Rekening;

class RekeningController extends BaseCrudController
{
    protected $model = Rekening::class;
    protected $routePrefix = 'rekening.';

    public function pageSetting()
    {
        $parent = parent::pageSetting();

        $parent['listTitle'] = 'Data Rekening';
        $parent['additionalActions'] = [
            [
                'label' => 'Buku Besar',
                'url' => '/laporan/buku-besar/{id}'
            ]
        ];

        return $parent;
    }
}

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

        return $parent;
    }
}

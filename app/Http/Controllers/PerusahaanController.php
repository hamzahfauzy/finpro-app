<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;

class PerusahaanController extends BaseCrudController
{
    protected $model = Perusahaan::class;
    protected $routePrefix = 'perusahaan.';

    public function pageSetting()
    {
        $parent = parent::pageSetting();

        $parent['listTitle'] = 'Data Perusahaan';

        return $parent;
    }
}

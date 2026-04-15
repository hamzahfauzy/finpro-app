<?php

namespace App\Http\Controllers;

use App\Models\Modal;

class ModalController extends BaseCrudController
{
    protected $model = Modal::class;
    protected $routePrefix = 'modal.';

    public function pageSetting()
    {
        $parent = parent::pageSetting();

        $parent['listTitle'] = 'Data Modal';

        return $parent;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OptionController extends Controller {

    public function get(Request $request)
    {
        $model = $request->model;
        $dependsValue = $request->depends_value;
        $foreignKey = $request->foreign_key;

        $query = $model::query();

        if ($dependsValue && $foreignKey) {
            $query->where($foreignKey, $dependsValue);
        }

        return $query->get();
    }

}
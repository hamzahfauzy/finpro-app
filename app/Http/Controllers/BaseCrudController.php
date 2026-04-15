<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BaseCrudController extends Controller {

    protected $viewPath = 'crud.';
    protected $routePrefix = 'crud.';
    protected $model;

    public function __construct()
    {
        View::share('page_setting', $this->pageSetting());
    }

    public function pageSetting(){
        return [
            'listTitle' => 'Data List',
            'createTitle' => 'Create Data',
            'createButton' => true,
            'editButton' => true,
            'deleteButton' => true,
            'editTitle' => 'Edit Data',
            'detailTitle' => 'Detail Data',
            'routePrefix' => $this->routePrefix
        ];
    }

    public function getModel(){
        return new $this->model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $model = $this->getModel();
        $data = $model->get();
        return view($this->viewPath.'index', compact('data','model'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $model = $this->getModel();
        $data = null;
        return view($this->viewPath.'form', compact('model', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->getModel()->create($request->all());
        return redirect()->route($this->routePrefix .'index')->with('success', 'Data berhasil disimpan');;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $model = $this->getModel();
        return view($this->viewPath.'show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $model = $this->getModel();
        $data  = $model->find($id);
        return view($this->viewPath.'form', compact('model', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $this->getModel()->find($id)->update($request->all());
        return redirect()->route($this->routePrefix .'index')->with('success', 'Data berhasil diperbaharui');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $this->getModel()->find($id)->delete();
        return redirect()->route($this->routePrefix .'index')->with('success', 'Data berhasil dihapus');;
    }

}
<?php

namespace App\Http\Controllers\API;

use App\Models\Province;

class ProvinceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Province::orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

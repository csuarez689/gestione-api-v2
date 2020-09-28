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
        $data = Province::where('id', 74)->get();
        return $this->toResourceCollection($data);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\HighSchoolType;

class HighSchoolTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = HighSchoolType::orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

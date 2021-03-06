<?php

namespace App\Http\Controllers\API;

use App\Models\SchoolType;

class SchoolTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SchoolType::orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\SchoolAmbit;

class SchoolAmbitController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SchoolAmbit::all();
        return $this->toResourceCollection($data);
    }
}

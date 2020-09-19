<?php

namespace App\Http\Controllers\API;

use App\Models\SchoolSector;

class SchoolSectorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SchoolSector::all();
        return $this->toResourceCollection($data);
    }
}

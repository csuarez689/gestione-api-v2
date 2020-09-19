<?php

namespace App\Http\Controllers\API;

use App\Models\SchoolLevel;

class SchoolLevelController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SchoolLevel::orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

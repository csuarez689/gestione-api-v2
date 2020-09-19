<?php

namespace App\Http\Controllers\API;

use App\Models\Department;

class LocalityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $data = $department->localities()->orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

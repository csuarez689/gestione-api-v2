<?php

namespace App\Http\Controllers\API;

use App\Models\Province;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Province $province)
    {
        $data = $province->departments()->OrderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\SchoolCategory;

class SchoolCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SchoolCategory::orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

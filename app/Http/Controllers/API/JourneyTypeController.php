<?php

namespace App\Http\Controllers\API;

use App\Models\JourneyType;

class JourneyTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JourneyType::orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

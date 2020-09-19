<?php

namespace App\Http\Controllers\API;

use App\Models\JobState;

class JobStateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JobState::orderBy('name')->get();
        return $this->toResourceCollection($data);
    }
}

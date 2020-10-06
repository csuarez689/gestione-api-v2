<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;

class ReportsController extends BaseController
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        return [];
    }
}

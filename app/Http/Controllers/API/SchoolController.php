<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;

class SchoolController extends BaseController
{

    public function __construct()
    {
        $this->middleware('role:admin')->except('show');
        $this->middleware('can:view,school')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::with([
            'locality.department',
            'user',
            'ambit',
            'sector',
            'type',
            'level',
            'category',
            'journey_type',
            'high_school_type'
        ])->applyQueryParams();
        return $this->toResourceCollection($schools);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolRequest $request)
    {
        $school = School::create($request->validated());
        return $this->toResource($school);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        $school->loadMissing([
            'locality.department',
            'user',
            'ambit',
            'sector',
            'type',
            'level',
            'category',
            'journey_type',
            'high_school_type'
        ]);
        return $this->toResource($school);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->update($request->validated());
        return $this->toResource($school);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();
        return response()->json(['id' => $school->id]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreTeachingPlantRequest;
use App\Http\Requests\UpdateTeachingPlantRequest;
use App\Models\School;
use App\Models\TeachingPlant;

class TeachingPlantController extends BaseController
{

    public function __construct()
    {
        $this->middleware('role:regular');

        $this->middleware('can:view,school')->only(['index', 'store']);
        $this->middleware('can:view,teachingPlant')->only('show');
        $this->middleware('can:update,teachingPlant')->only('update');
        $this->middleware('can:delete,teachingPlant')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(School $school)
    {
        $teachingPlant = $school->teaching_plant()->with(['teacher.locality.department', 'job_state'])->filterYearDivision()->applyQueryParams();
        return $this->toResourceCollection($teachingPlant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(StoreTeachingPlantRequest $request, School $school)
    {
        $formData = array_merge($request->validated(), ['school_id' => $school->id]);
        $teachingPlant = TeachingPlant::create($formData);

        return $this->toResource($teachingPlant);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeachingPlant  $teachingPlant
     * @return \Illuminate\Http\Response
     */
    public function show(TeachingPlant $teachingPlant)
    {
        $teachingPlant->loadMissing('teacher.locality.department', 'job_state');
        return $this->toResource($teachingPlant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeachingPlant  $teachingPlant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeachingPlantRequest $request, TeachingPlant $teachingPlant)
    {
        $teachingPlant->update($request->validated());

        return $this->toResource($teachingPlant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeachingPlant  $teachingPlant
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeachingPlant $teachingPlant)
    {
        $teachingPlant->delete();
        return response()->json(['id' => $teachingPlant->id]);
    }
}

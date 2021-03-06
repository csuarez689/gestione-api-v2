<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use Exception;
use Illuminate\Database\QueryException;

class TeacherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::with('locality.department')->applyQueryParams();
        return $this->toResourceCollection($teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        // dd($request->validated());
        $teacher = Teacher::create($request->validated());
        return $this->toResource($teacher);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        $teacher->loadMissing('locality.department');
        return $this->toResource($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());
        return $this->toResource($teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            return response()->json(['id' => $teacher->id]);
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] == 1451) {
                return response()->json(["message" => 'No se puede eliminar el registro, el docente posee puestos de trabajo activos.'], 409);
            }
        }
    }
}

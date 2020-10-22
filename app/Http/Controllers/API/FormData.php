<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormData extends Controller
{
    private $formData = [
        'ambits' => \App\Models\SchoolAmbit::class,
        'categories' => \App\Models\SchoolCategory::class,
        'levels' => \App\Models\SchoolLevel::class,
        'sectors' => \App\Models\SchoolSector::class,
        'types' => \App\Models\SchoolType::class,
        'journey_types' => \App\Models\JourneyType::class,
        'job_states' => \App\Models\JobState::class,
        'high_school_types' => \App\Models\HighSchoolType::class,
        'subjects' => 'SELECT DISTINCT subject AS name FROM `schools_teachers` ORDER BY subject ASC',
        'teacher_titles' => 'SELECT DISTINCT teacher_title AS name FROM schools_teachers UNION SELECT DISTINCT title1 AS name FROM orden_meritos UNION SELECT DISTINCT title2 AS name FROM orden_meritos ORDER BY name',
        'school_orientations' => 'SELECT DISTINCT orientation AS name FROM `schools` ORDER BY orientation ASC',
        'om_years' => 'SELECT DISTINCT year FROM orden_meritos ORDER BY year',
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = [];
        if ($request->include) {
            $includes = explode(",", $request->include);

            foreach ($includes as $key => $value) {
                if (array_key_exists($value, $this->formData)) {
                    $data[$value] = class_exists($this->formData[$value])
                        ?  $this->formData[$value]::orderBy('name')->get()
                        : DB::select($this->formData[$value]);
                }
            }
        }
        return response()->json($data);
    }
}

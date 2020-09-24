<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        'high_school_types' => \App\Models\HighSchoolType::class
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
                    $data[$value] = $this->formData[$value]::orderBy('name')->get();
                }
            }
        }
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportsController extends BaseController
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function schoolsCount(Request $request)
    {

        $sectorFilter = $request->query('sector_id') ? (int)$request->query('sector_id') : '%';
        $typeFilter = $request->query('type_id') ? (int)$request->query('type_id') : '%';
        $levelFilter = $request->query('level_id') ? (int)$request->query('level_id') : '%';

        $departments = DB::table('schools')
            ->join('localities', 'schools.locality_id', '=', 'localities.id')
            ->join('departments', 'localities.department_id', '=', 'departments.id')
            ->join('provinces', 'departments.province_id', '=', 'provinces.id')
            ->select('provinces.name as province', 'departments.name as department', 'localities.name as locality', DB::raw('count(*) as total'))
            ->where('schools.level_id', 'like', $levelFilter)
            ->where('schools.sector_id', 'like', $sectorFilter)
            ->where('schools.type_id', 'like', $typeFilter)
            ->groupBy(['province', 'department', 'locality'])
            ->get()
            ->groupBy('department'); //For collection output

        $total_province = DB::table('schools')
            ->where('schools.level_id', 'like', $levelFilter)
            ->where('schools.sector_id', 'like', $sectorFilter)
            ->where('schools.type_id', 'like', $typeFilter)->count();

        $data = new Collection();

        //Format output custom json
        if ($total_province) {
            $departments->each(function ($item, $key) use ($data) {
                $total_department = $item->sum('total');
                $data->push(["department" => $key, "total" => $total_department, "localities" => $item]);
            });
            $data = ["total" => $total_province, "departments" => $data];
        }

        return response()->json($data);
    }
}

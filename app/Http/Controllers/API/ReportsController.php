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

    //get amount of schools per provinces, departments an localities groups
    //can be filtered by school type, sector or level
    public function schoolsCount(Request $request)
    {
        $sectorFilter = $request->query('sector_id') ? (int)$request->query('sector_id') : '%';
        $typeFilter = $request->query('type_id') ? (int)$request->query('type_id') : '%';
        $levelFilter = $request->query('level_id') ? (int)$request->query('level_id') : '%';

        $data = DB::table('schools')
            ->selectRaw('count(schools.id) as total,provinces.name as province,departments.name as department, localities.name as locality')
            ->join('localities', 'schools.locality_id', '=', 'localities.id')
            ->join('departments', 'localities.department_id', '=', 'departments.id')
            ->join('provinces', 'departments.province_id', '=', 'provinces.id')
            ->where('schools.level_id', 'like', $levelFilter)
            ->where('schools.sector_id', 'like', $sectorFilter)
            ->where('schools.type_id', 'like', $typeFilter)
            ->groupBy('department', 'locality')
            ->get()
            ->groupBy(['province', 'department']); //For collection output

        $formatedData = new Collection();

        // Format output custom json
        $data->each(function ($item, $key) use ($formatedData) {
            $departments = new Collection();
            $item->each(function ($item, $key) use ($departments) {
                $departments->push(["department" => $key, "total" => $item->sum('total'), "localities" => $item]);
            });
            $formatedData->push(["province" => $key, "total" => $departments->sum('total'), "departments" => $departments]);
        });

        return response()->json($formatedData);
    }

    //get amount of charges on teaching plant
    //amount of peoples
    //avg of charges per people
    //grouped by provinces, departments and localities
    public function teachingPlantCharges()
    {
        $data = DB::table('schools_teachers')
            ->selectRaw(
                "count(DISTINCT schools_teachers.teacher_id) as peoples,
                            count(schools_teachers.teacher_id) as charges,
                            round(count(schools_teachers.teacher_id)/count(DISTINCT schools_teachers.teacher_id),2) AS avg_charges_per_people,
                            provinces.name as province,departments.name as department,localities.name as locality"
            )
            ->join('schools', 'schools_teachers.school_id', '=', 'schools.id')
            ->join('localities', 'schools.locality_id', '=', 'localities.id')
            ->join('departments', 'localities.department_id', '=', 'departments.id')
            ->join('provinces', 'departments.province_id', '=', 'provinces.id')
            ->groupBy('department', 'locality')
            ->get()
            ->groupBy(['province', 'department']); //For collection output

        $formatedData = new Collection();

        // Format output custom json
        $data->each(function ($item, $key) use ($formatedData) {
            $departments = new Collection();
            $item->each(function ($item, $key) use ($departments) {
                $departments->push([
                    "department" => $key,
                    "peoples" => $item->sum('peoples'),
                    "charges" => $item->sum('charges'),
                    "avg_charges_per_people" => number_format($item->sum('charges') / $item->sum('peoples'), 2),
                    "localities" => $item
                ]);
            });
            $formatedData->push([
                "province" => $key,
                "peoples" => $departments->sum('peoples'),
                "charges" => $departments->sum('charges'),
                "avg_charges_per_people" => number_format($departments->sum('charges') / $departments->sum('peoples'), 2),
                "departments" => $departments
            ]);
        });

        return response()->json($formatedData);
    }

    //get amount of om inscriptions
    //amount of peoples register on om
    //avg of inscriptions per person
    //grouped by provinces, departments and localities
    //can be filtered by year
    public function omInscriptions(Request $request)
    {
        $yearFilter = $request->query('year') ? (int)$request->query('year') : '%';

        $data = DB::table('orden_meritos')
            ->selectRaw('COUNT(DISTINCT orden_meritos.cuil) AS persons,
                                    COUNT(*) AS inscriptions,
                                    ROUND((COUNT(*) / COUNT(DISTINCT cuil)),2) AS avg_inscriptions_per_person,
                                    orden_meritos.year AS year, provinces.name AS province, departments.name AS department, localities.name AS locality_name')
            ->join('localities', 'localities.name', '=', 'orden_meritos.locality')
            ->join('departments', 'departments.id', '=', 'localities.department_id')
            ->join('provinces', 'provinces.id', '=', 'departments.province_id')
            ->where('orden_meritos.year', 'like', $yearFilter)
            ->groupBy('province', 'department', 'locality_name')
            ->get()
            ->groupBy(['province', 'department']); //For collection output


        $formatedData = new Collection();

        // Format output custom json
        $data->each(function ($item, $key) use ($formatedData) {
            $departments = new Collection();
            $item->each(function ($item, $key) use ($departments) {
                $departments->push([
                    "department" => $key,
                    "persons" => $item->sum('persons'),
                    "inscriptions" => $item->sum('inscriptions'),
                    "avg_inscriptions_per_person" => number_format($item->sum('inscriptions') / $item->sum('persons'), 2),
                    "localities" => $item
                ]);
            });
            $formatedData->push([
                "province" => $key,
                "persons" => $departments->sum('persons'),
                "inscriptions" => $departments->sum('inscriptions'),
                "avg_inscriptions_per_person" => number_format($departments->sum('inscriptions') / $departments->sum('persons'), 2),
                "departments" => $departments
            ]);
        });

        return response()->json($formatedData);
    }


    //get amount of om inscriptions
    //amount of persons registered who actually has a job
    //amount of persons registered who actually doesnt have a job
    //grouped by provinces, departments and localities
    public function omInscriptionsJobs()
    {

        // SELECT COUNT(DISTINCT cuil) AS "total_persons", SUM(IF(has_charge IS NULL,1,0)) as "without_charge", province, department, locality
        // FROM (SELECT DISTINCT orden_meritos.cuil, schools_teachers.id as "has_charge", provinces.name AS "province", departments.name AS "department", localities.name AS 		"locality"
        //       FROM orden_meritos
        //       JOIN teachers ON orden_meritos.cuil=teachers.cuil
        //       LEFT JOIN schools_teachers ON teachers.id=schools_teachers.teacher_id
        //       JOIN localities ON localities.name like orden_meritos.locality
        //       JOIN departments ON localities.department_id=departments.id
        //       JOIN provinces ON departments.province_id=provinces.id) AS RESULT
        // GROUP BY province, department, locality

        $subQuery = DB::table('orden_meritos')
            ->selectRaw('DISTINCT orden_meritos.cuil, schools_teachers.id AS has_charge,
                                    provinces.name AS province, departments.name AS department,localities.name AS locality')
            ->join('teachers', 'orden_meritos.cuil', '=', 'teachers.cuil')
            ->leftJoin('schools_teachers', 'teachers.id', '=', 'schools_teachers.teacher_id')
            ->join('localities', 'localities.name', '=', 'orden_meritos.locality')
            ->join('departments', 'departments.id', '=', 'localities.department_id')
            ->join('provinces', 'provinces.id', '=', 'departments.province_id');

        $data = DB::table($subQuery)
            ->selectRaw('COUNT(DISTINCT cuil) AS total_persons,
                            SUM(IF(has_charge IS NULL,1,0)) as without_charge,
                            province, department, locality')
            ->groupBy('province', 'department', 'locality')
            ->get()
            ->groupBy(['province', 'department']); //For collection output

        $formatedData = new Collection();

        // Format output custom json
        $data->each(function ($item, $key) use ($formatedData) {
            $departments = new Collection();
            $item->each(function ($item, $key) use ($departments) {
                $departments->push([
                    "department" => $key,
                    "total_persons" => $item->sum('total_persons'),
                    "without_charge" => $item->sum('without_charge'),
                    "localities" => $item
                ]);
            });
            $formatedData->push([
                "province" => $key,
                "total_persons" => $departments->sum('total_persons'),
                "without_charge" => $departments->sum('without_charge'),
                "departments" => $departments
            ]);
        });


        return response()->json($formatedData);
    }
}

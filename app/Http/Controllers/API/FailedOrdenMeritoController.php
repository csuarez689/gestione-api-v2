<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreOrdenMeritoRequest;
use App\Models\FailedOrdenMerito;
use App\Models\OrdenMerito;
use Exception;
use Illuminate\Support\Facades\DB;

class FailedOrdenMeritoController extends BaseController
{

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $failedOrdenMerito = FailedOrdenMerito::applyQueryParams();
        return $this->toResourceCollection($failedOrdenMerito);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FailedOrdenMerito  $failedOrdenMerito
     * @return \Illuminate\Http\Response
     */
    public function show(FailedOrdenMerito $failedOrdenMerito)
    {
        return $this->toResource($failedOrdenMerito);
    }

    /**
     * Repair a failedOrdenMerito and store in success OrdenMerito
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function repair(StoreOrdenMeritoRequest $request, FailedOrdenMerito $failedOrdenMerito)
    {
        DB::beginTransaction();
        try {
            $failedOrdenMerito->delete();
            $ordenMerito = OrdenMerito::create($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $this->toResource($ordenMerito);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FailedOrdenMerito  $failedOrdenMerito
     * @return \Illuminate\Http\Response
     */
    public function destroy(FailedOrdenMerito $failedOrdenMerito)
    {
        $failedOrdenMerito->delete();
        return response()->json(['id' => $failedOrdenMerito->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function truncate()
    {
        DB::table('failed_orden_meritos')->truncate();
        return response()->json(['message' => 'Se han eliminado los registros erroneos.']);
    }
}

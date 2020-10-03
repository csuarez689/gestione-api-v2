<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ExcededFailedImportRows;
use App\Http\Requests\UploadFileOrdenMeritoRequest;
use App\Imports\OrdenMeritoImport;
use App\Models\OrdenMerito;
use Exception;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class OrdenMeritoController extends BaseController
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
        $ordenMerito = OrdenMerito::applyQueryParams();
        return $this->toResourceCollection($ordenMerito);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrdenMerito  $ordenMerito
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenMerito $ordenMerito)
    {
        return $this->toResource($ordenMerito);
    }

    /**
     * Upload the specified resource in storage
     * and process the file for storage in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(UploadFileOrdenMeritoRequest $request)
    {
        try {
            $filename = time() . '.' . $request->file('file')->getClientOriginalExtension();
            $path = Storage::putFileAs('ordenes_merito', $request->file('file'), $filename);

            $headers = (new HeadingRowImport)->toArray($path);

            if ($headerErrors = $this->validateHeaders($headers[0][0])) {
                return response()->json(['message' => $headerErrors], 422);
            }

            $import = new OrdenMeritoImport(request()->year);
            Excel::import($import, $path);
        } catch (ExcededFailedImportRows $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(["message" => "Ocurrio un error al procesar el archivo."], 500);
        }

        return response()->json(["failed_rows" => $import->getFailsCounter()]);
    }

    //------------------HELPERS------------------

    private function validateHeaders($headers)
    {
        $error = '';
        $requiredHeaders = ['region', 'nivel', 'apellido', 'nombre', 'cuil', 'sexo', 'localidad', 'cargo', 'titulo_1', 'titulo_2', 'incumbencia'];
        $notExist = array_diff($requiredHeaders, array_values($headers));
        if (!empty($notExist)) {
            $error = 'Los siguientes encabezados son requeridos: ' . implode(', ', $notExist) . '.';
        }
        return $error;
    }
}

<?php

namespace App\Traits;

use App\Http\Resources\BaseResourceCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

trait ApiResponser
{

    /**
     * Create a custom success json response
     *
     * @param Mixed $data
     * @param Integer $code default value 200
     * @return \Illuminate\Http\JsonResponse
     **/
    protected function successJsonResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    /**
     * Create a custom error json response
     *
     * @param Mixed $message
     * @param Integer $code
     * @return JsonResponse
     **/
    protected function errorJsonResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }


    protected function showMessage($message, $code = 200)
    {
        return response()->json(['data' => $message], $code);
    }

    /**
     * Transform the collection to api resource collection
     * and create a cached the response
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $collection collection already paginated
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     **/
    protected function toResourceCollection($collection)
    {
        if ($collection->isEmpty()) {
            return new BaseResourceCollection($collection);
        }
        $apiResourceClass = $collection->first()->apiResourceClass;
        $transformed = $apiResourceClass::collection($collection);
        // $collection = $this->cachedResponse($collection);
        return $transformed;
    }

    /**
     * Transform model to api resource
     *
     * @param \Illuminate\Database\Eloquent\Model $instance
     * @return \Illuminate\Http\Resources\Json\JsonResource
     **/
    protected function toResource(Model $instance)
    {
        //obtain the corresponding API resource for the model
        $apiResourceClass = $instance->apiResourceClass;
        $transformed = new $apiResourceClass($instance);
        return $transformed;
    }

    protected function cachedResponse($data)
    {
        // se ordenan los parametros y reconstruye full url
        // para diferenciar las peticiones y la cache funcione adecuadamente
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30, function () use ($data) {
            return $data;
        });
        return $data;
    }
}

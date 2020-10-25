<?php

namespace App\Observers;

use App\Models\Locality;
use App\Models\OrdenMerito;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;

class OrdenMeritoObserver
{
    /**
     * Handle the orden merito "created" event.
     *
     * @param  \App\Models\OrdenMerito  $ordenMerito
     * @return void
     */
    public function created(OrdenMerito $ordenMerito)
    {

        $validator = Validator::make($ordenMerito->toArray(), [
            'name' => 'required|string|min:3|max:100',
            'last_name' => 'required|string|min:3|max:100',
            'cuil' => ['unique:teachers,cuil', 'required', 'regex:/\b(20|23|24|27)(\D)-?[0-9]{8}-(\D)?[0-9]/'],
            'gender' => 'required|in:MASCULINO,FEMENINO',
        ]);
        if (!$validator->fails()) {
            $locality = Locality::where('name', 'like', $ordenMerito->locality)->first();
            if ($locality) {
                $data = $validator->validated();
                $data['locality_id'] = $locality->id;
                Teacher::create($data);
            }
        }
    }
}

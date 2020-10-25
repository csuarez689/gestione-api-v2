<?php

namespace App\Imports;

use App\Exceptions\ExcededFailedImportRows;
use App\Models\FailedOrdenMerito;
use App\Models\OrdenMerito;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdenMeritoImport implements ToCollection, WithHeadingRow
{

    private $year;

    private $failsCounter;

    private $successCounter;

    private $currentCharge;

    public function __construct($year)
    {
        $this->year = $year;
        $this->failsCounter = 0;
        $this->successCounter = 0;
        $this->currentCharge = "";
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function collection(Collection $rows)
    {
        $failedOrders = array();
        foreach ($rows as $row) {
            $this->currentCharge = $row['cargo'];
            $mappedRow = [
                'incumbency' => $row['incumbencia'],
                'region' => $row['region'],
                'level' => $row['nivel'],
                'name' => $row['nombre'],
                'last_name' => $row['apellido'],
                'cuil' => $this->formatCuil($row['cuil']),
                'gender' => $row['sexo'],
                'locality' => $row['localidad'],
                'charge' => $row['cargo'],
                'title1' => $row['titulo_1'],
                'title2' => $row['titulo_2'],
                'year' => $this->year,
            ];;

            $validator = Validator::make($mappedRow,   $this->getRules(), $this->getValidationMessages());
            if ($validator->fails()) {
                if ($this->failsCounter > 50) {
                    throw new ExcededFailedImportRows();
                }
                $this->failsCounter += 1;
                $errors = json_encode($validator->messages()->get('*'));
                $mappedRow['errors'] = $errors;
                array_push($failedOrders, $mappedRow);
            } else {
                OrdenMerito::create($mappedRow);
                $this->successCounter += 1;
            }
        }
        FailedOrdenMerito::insert($failedOrders);
    }

    private function getRules(): array
    {
        return [
            'incumbency' => ['nullable', 'regex:/(A1|A2|A3|B1|B2|B3|B4|B5|C1|C2|C3|C4|C5|NULL)/i'],
            'region' => 'required|integer|between:1,6',
            'level' => ['required', 'regex:/(inicial|primario|secundario)/i'],
            'last_name' => 'required|max:50',
            'name' => 'required|max:50',
            'cuil' => [
                'required', 'regex:/\b(20|23|24|27)(\D)-?[0-9]{8}-(\D)?[0-9]/',
                Rule::unique('orden_meritos', 'cuil')->where(function ($query) {
                    $query->where([
                        ['year', '=', $this->year],
                        ['charge', '=', $this->currentCharge],
                    ]);
                })
            ],
            'gender' => ['required', 'regex:/(femenino|masculino)/i'],
            'locality' => 'required|max:50',
            'charge' => 'required|max:100',
            'title1' => 'required|max:100',
            'title2' => 'nullable|max:100',
            'year' => 'required|integer|between:2000,2030'
        ];
    }

    private function getValidationMessages(): array
    {
        return [
            'incumbency.regex' => 'Valores permitidos: A1|A2|A3|B1|B2|B3|B4|B5|C1|C2|C3.',
            'level.regex' => 'Valores permitidos: Inicial|Primario|Secundario.',
            'cuil.regex' => 'Formato CUIL/CUIT invalido.',
            'cuil.unique' => 'El CUIL/CUIT ya se encuentra registrado con este cargo y año.',

        ];
    }
    public function formatCuil($value): string
    {
        $header = substr($value, 0, 2);
        $dni = substr($value, 2, -1);
        $tail = substr($value, -1);

        return $header . '-' . $dni . '-' . $tail;
    }

    public function getFailsCounter(): int
    {
        return $this->failsCounter;
    }

    public function getSuccessCounter(): int
    {
        return $this->successCounter;
    }

    public function getJsonResponse(): array
    {
        return ["success_rows" => $this->getSuccessCounter(), "failed_rows" => $this->getFailsCounter()];
    }
}

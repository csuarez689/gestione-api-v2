<?php

namespace Database\Factories;

use App\Models\Province;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        //only for San Luis
        $department = Province::find(74)->departments->random();
        $locality = $department->localities->random()->id;

        $headerCuil = $this->faker->randomElement(['20', '23', '24', '27']);
        $dni = strval($this->faker->numberBetween(10000000, 60000000));
        $lastCuil = $this->faker->numberBetween(0, 9);
        $cuil = $headerCuil . '-' . $dni . '-' . $lastCuil;

        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'cuil' => $cuil,
            'gender' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'locality_id' => $locality,

        ];
    }
}

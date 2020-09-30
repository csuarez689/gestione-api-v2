<?php

namespace Database\Factories;

use App\Models\JobState;
use App\Models\School;
use App\Models\Teacher;
use App\Models\TeachingPlant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeachingPlantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeachingPlant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => $this->faker->randomDigitNotNull,
            'division' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'subject' => strtoupper($this->faker->word),
            'monthly_hours' => $this->faker->numberBetween(10, 200),
            'teacher_title' => $this->faker->sentence(4, true),
            'teacher_category_title' => $this->faker->randomElement(['Docente', 'No Docente']),
            'school_id' => School::all()->random()->id,
            'teacher_id' => Teacher::all()->random()->id,
            'job_state_id' => JobState::all()->random()->id,
        ];
    }
}

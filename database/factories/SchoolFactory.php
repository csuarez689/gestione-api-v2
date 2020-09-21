<?php

namespace Database\Factories;

use App\Models\HighSchoolType;
use App\Models\JourneyType;
use App\Models\Province;
use App\Models\School;
use App\Models\SchoolAmbit;
use App\Models\SchoolCategory;
use App\Models\SchoolLevel;
use App\Models\SchoolSector;
use App\Models\SchoolType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SchoolFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = School::class;

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
        $level = SchoolLevel::all()->random()->id;
        $user = User::where('isAdmin', 0)->doesntHave('school')->get()->random()->id;
        //only if is high school
        $highScoolType = ($level == 3) ? HighSchoolType::all()->random()->id : null;

        return [
            'name' => ucwords($this->faker->words(random_int(3, 8), true)),
            'cue' => $this->faker->randomNumber(9, true),
            'address' => $this->faker->streetAddress,
            'phone' => $this->faker->randomElement([null, $this->faker->phoneNumber]),
            'internal_phone' => $this->faker->randomElement([null, $this->faker->phoneNumber]),
            'email' => $this->faker->email,
            'number_students' => $this->faker->randomNumber(3),
            'bilingual' => $this->faker->randomElement([true, false]),
            'director' => $this->faker->name,
            'orientation' => ucwords($this->faker->words(random_int(4, 8), true)),
            'ambit_id' => SchoolAmbit::all()->random()->id,
            'sector_id' => SchoolSector::all()->random()->id,
            'type_id' => SchoolType::all()->random()->id,
            'level_id' => $level,
            'category_id' => SchoolCategory::all()->random()->id,
            'journey_type_id' => JourneyType::all()->random()->id,
            'locality_id' => $locality,
            'high_school_type_id' => $highScoolType,
            'user_id' => $this->faker->randomElement([$user, null])
        ];
    }
}

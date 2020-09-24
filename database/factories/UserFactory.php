<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'dni' => strval($this->faker->numberBetween(10000000, 60000000)),
            'email' => $this->faker->email,
            'email_verified_at' => $this->faker->randomElement([now(), null]),
            'password' => Hash::make('secret'),
            'phone' => $this->faker->phoneNumber,
            'isAdmin' => User::REGULAR_USER,
        ];
    }
}

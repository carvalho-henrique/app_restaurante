<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'number_people' => $this->faker->numberBetween(0, 5),
            'reservation_date' => $this->faker->dateTimeBetween(now(), '+10 days'),
            'start_time' => $this->faker->time('18:00'),
            'end_time' => $this->faker->time('20:00'),
        ];
    }
}

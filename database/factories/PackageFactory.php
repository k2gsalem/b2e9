<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => Str::upper($this->faker->unique()->bothify('???###')),
            'bids' => $this->faker->randomElement(['5', '10', '15', '20', '25']),
            'actual_amount' => $this->faker->numberBetween(100, 1000),
            'sale_amount' => $this->faker->numberBetween(100, 1000)
        ];
    }
}

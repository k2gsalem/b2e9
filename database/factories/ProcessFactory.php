<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProcessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::upper($this->faker->unique()->word()),
            'hourly_price' => $this->faker->numberBetween(10, 100),
            'description' => $this->faker->paragraph()
        ];
    }
}

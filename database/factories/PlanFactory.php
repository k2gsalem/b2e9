<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\PlanBenefit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => Str::upper($this->faker->unique()->bothify('??####')),
            'type' => $this->faker->randomElement(['standard', 'premium']),
            'title' => Str::upper($this->faker->word()),
            'description' => $this->faker->paragraph(),
            'actual_amount' => $this->faker->numberBetween(100, 1000),
            'sale_amount' => $this->faker->numberBetween(100, 1000),
            'fresh_bids' => $this->faker->numberBetween(100, 1000),
            'additional_bids' => $this->faker->numberBetween(100, 1000),
            'validity_days' => $this->faker->numberBetween(15, 365)
        ];
    }

    public function withBenefits($count = 4)
    {
        return $this->has(
            PlanBenefit::factory($count)
                ->state(function (array $attributes, Plan $model) {
                    return [
                        'plan_id' => $model->id
                    ];
                }),
            'benefits'
        );
    }
}

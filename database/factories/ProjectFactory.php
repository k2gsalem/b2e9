<?php

namespace Database\Factories;

use App\Models\Process;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function configure()
    {
        return $this->afterMaking(function (Project $model) {

        })->afterCreating(function (Project $model) {
            $model->update([
                'close_at' => $this->faker->dateTimeBetween($model->publish_at . ' + 3 hours', $model->publish_at . ' + 3 days')
            ]);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::ucfirst($this->faker->words(3, true)),
            'part_name' => Str::ucfirst($this->faker->words(3, true)),
            'drawing_number' => Str::ucfirst($this->faker->words(3, true)),
            'delivery_date' => $this->faker->dateTimeBetween('+4 days', '+30 days'),
            'location_preference' => $this->faker->numberBetween(3, 20),
            'raw_material_price' => $this->faker->numberBetween(10000, 1000000),
            'description' => $this->faker->paragraph(),
            'publish_at' => $this->faker->dateTimeBetween('-7 days', '+7 days')
        ];
    }
}

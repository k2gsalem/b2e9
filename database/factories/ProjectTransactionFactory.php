<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\ProjectTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $package_ids = Package::query()->where('active', 1)->pluck('id')->toArray();
        return [
            'package_id' => $this->faker->randomElement($package_ids),
            'bids' => $this->faker->randomElement(['5', '10', '15', '20', '25']),
            'base_amount' => 100,
            'gst_amount' => 18,
            'final_amount' => 118,
            'mode' => 'DUMMY'
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (ProjectTransaction $model) {
            //
        })->afterCreating(function (ProjectTransaction $model) {
            /*$model->update([
                'paid_at' => now()
            ]);*/
        });
    }
}

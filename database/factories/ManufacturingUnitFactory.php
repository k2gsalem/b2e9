<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Pincode;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturingUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pincodes = Location::query()->pluck('pincode')->toArray();
        return [
            'address' => $this->faker->streetAddress(),
//            'pincode' => $this->faker->randomElement($pincodes),
            'pincode' => $this->faker->numberBetween(600001, 600042)
        ];
    }
}

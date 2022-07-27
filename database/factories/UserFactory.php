<?php

namespace Database\Factories;

use App\Models\ManufacturingUnit;
use App\Models\Process;
use App\Models\Project;
use App\Models\ProjectTransaction;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

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
            'name' => $this->faker->company(),
            'role' => 'supplier',
            'phone' => $this->faker->unique()->numerify('9#########'),
            'phone_verified_at' => now(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'contact_name' => $this->faker->name(),
            'organization_type' => $this->faker->randomElement(['LLB', 'PVT LTD', 'Partnership', 'Proprietorship']),
            'incorporation_date' => $this->faker->date('Y-m-d', 'now'),
            'alternate_phone' => $this->faker->numerify('8#########'),
            'gst_number' => $this->faker->regexify('[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}'),
            'sales_turnover' => $this->faker->numberBetween(1, 100),
            'employees_count' => $this->faker->numberBetween(1, 500),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'referrer_id' => null
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (User $user) {
            //
        })->afterCreating(function (User $user) {

        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function withReferrer()
    {
        return $this->state(function (array $attributes) {
            $referrer = User::query()->select('id')->inRandomOrder()->first();
            return [
                'referrer_id' => $referrer ? $referrer->id : null
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }

    public function withManufacturingUnits($count = 2)
    {
        return $this->has(
            ManufacturingUnit::factory()
                ->count($count)
                ->state(function (array $attributes, User $user) {
                    return [
                        'user_id' => $user->id
                    ];
                }),
            'manufacturing_units'
        );
    }

    public function withProjects($count = 5, $role = null)
    {
        return $this->state(function (array $attributes) use ($role) {
            return [
                'role' => $role ?: $this->faker->randomElement(['customer', 'both'])
            ];
        })->has(
            Project::factory()
                ->count($count)
                ->state(function (array $attributes, User $user) {
                    $mu = $user->manufacturing_units()->inRandomOrder()->first();

                    return [
                        'user_id' => $user->id,
                        'manufacturing_unit_id' => $mu->id
                    ];
                })
                ->has(
                    ProjectTransaction::factory()->count(1)
                , 'transactions'),
            'projects'
        );
    }
}

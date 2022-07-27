<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Package;
use App\Models\Plan;
use App\Models\Process;
use App\Models\ProjectTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Permission as ModelsPermission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
      public function run()
    {
        Admin::factory()->state(['email' => 'admin@mail.com'])->create();
        Package::factory()->count(5)->create();
        Plan::factory()->count(5)->withBenefits()->create();
        Process::factory(50)->create();

        User::factory()
            ->state([
                'phone' => '9876543210'
            ])
            ->withManufacturingUnits()
            ->withProjects(12, 'both')
            ->create()
            ->each(function (User $user) {
                $user->machines()->saveMany(
                    Process::query()->inRandomOrder()->limit(3)->get()
                );
                $user->processes()->saveMany(
                    Process::query()->inRandomOrder()->limit(3)->get()
                );
            });
         User::factory()->count(10)
             ->withReferrer()
             ->withManufacturingUnits()
             ->withProjects()
             ->create()
             ->each(function (User $user) {
                 $user->machines()->saveMany(
                     Process::query()->inRandomOrder()->limit(3)->get()
                 );
                 $user->processes()->saveMany(
                     Process::query()->inRandomOrder()->limit(3)->get()
                 );
             });
        User::factory()->count(20)
            ->withReferrer()
            ->withManufacturingUnits()
            ->create()
            ->each(function (User $user) {
                $user->machines()->saveMany(
                    Process::query()->inRandomOrder()->limit(3)->get()
                );
                $user->processes()->saveMany(
                    Process::query()->inRandomOrder()->limit(3)->get()
                );
            });


        // ProjectTransaction::query()->whereNull('paid_at')->each(function ($model) {
        //     $model->update([
        //         'paid_at' => now()
        //     ]);
        // });

        $permissions = [
            'users.list',
            'users.edit',
            'users.reset_password',
            'projects.list',
            'projects.details',
            'projects.export',
            'materials.list',
            'materials.create',
            'materials.edit',
            'materials.import',
            'materials.export',
            'processes.list',
            'processes.create',
            'processes.edit',
            'processes.import',
            'blog.list',
            'blog.create',
            'blog.edit',
            'reports.project_transactions',
            'reports.subscriptions',
            'membership_plans.list',
            'membership_plans.create',
            'membership_plans.edit',
            'rfq_packages.list',
            'rfq_packages.create',
            'rfq_packages.edit',
            'newsletter.list',
            'newsletter.send',
            'website_settings',
            'locations.list',
            'locations.create',
            'locations.edit',
            'support',
        ];
        foreach ($permissions as $permission) {
            ModelsPermission::query()->updateOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }
    }
}

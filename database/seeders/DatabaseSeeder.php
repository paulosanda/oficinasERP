<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Company::factory()->create([
            'company_name' => 'PS Tech',
        ]);

        $pstech = Company::find(1);

        $user = User::create([
            'company_id' => $pstech->id,
            'name' => 'Paulo Sanda',
            'email' => 'paulosanda@gmail.com',
            'password' => '123',
            'enable' => true,
        ]);

        $this->call(RoleSeeder::class);

        $rootRole = Role::where('role', 'root')->first();

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $rootRole->id,
        ]);

        $this->call(CheckupObservationTypeSeeder::class);

        $this->call(SchedulableServiceSeeder::class);

        if (app()->environment('local')) {
            Company::factory()->count(10)->create();

            $companies = Company::where('id', '!=', 1)->get();

            foreach ($companies as $company) {
                $company_user = User::create([
                    'company_id' => $company->id,
                    'name' => fake()->name,
                    'email' => fake()->email,
                    'password' => '123',
                    'enable' => true,
                ]);
            }

            $users = User::where('company_id', '!=', 1)->get();

            foreach ($users as $user) {
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => 3,
                ]);
            }

            foreach ($companies as $company) {
                $i = 0;
                while ($i < 3) {
                    $company_user = User::create([
                        'company_id' => $company->id,
                        'name' => fake()->name,
                        'email' => fake()->email,
                        'password' => fake()->password,
                        'enable' => true,
                    ]);
                    UserRole::create([
                        'user_id' => $company_user->id,
                        'role_id' => 4,
                    ]);
                    $i++;
                }

            }

        }

    }
}

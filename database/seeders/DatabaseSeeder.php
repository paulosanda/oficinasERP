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
        // User::factory(10)->create();

        $company = Company::factory()->create([
            'razao_social' => 'PS Tech'
        ]);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Paulo Sanda',
            'email' => 'paulosanda@gmail.com',
            'password' => '123'
        ]);

        $this->call(RoleSeeder::class);

        $rootRole = Role::where('role', 'root')->first();

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $rootRole->id
        ]);
    }
}

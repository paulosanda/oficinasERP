<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basicRoles = [
            0 => [
                'role' => 'root',
                'type' => 'admin',
                'description' => 'super usuário',
            ],
            1 => [
                'role' => 'admin',
                'type' => 'admin',
                'description' => 'administrador',
            ],
            2 => [
                'role' => 'master',
                'type' => 'company',
                'description' => 'master do company',
            ],
            3 => [
                'role' => 'operator',
                'type' => 'company',
                'description' => 'operador do company',
            ],
        ];

        foreach ($basicRoles as $role) {
            Role::create([
                'role' => $role['role'],
                'type' => $role['type'],
                'role_description' => $role['description'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'role' =>'root',
                'type' => 'admin',
                'description' => 'super usuário'
            ],
            1 => [
                'role' => 'admin',
                'type' => 'admin',
                'description' => 'administrador'
            ],
            2 => [
                'role' => 'master',
                'type' => 'client',
                'description' => 'master do cliente'
            ],
            3 => [
                'role' => 'operator',
                'type' => 'client',
                'description' => 'oerador do cliente'
            ],
        ];

        foreach ($basicRoles as $role) {
            Role::create([
                'role' => $role['role'],
                'type' => $role['type'],
                'role_description' => $role['description']
            ]);
        }
    }
}

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
                'description' => 'super usuário'
            ],
            1 => [
                'role' => 'admin',
                'description' => 'administrador'
            ],
            2 => [
                'role' => 'client',
                'description' => 'cliente'
            ]
        ];

        foreach ($basicRoles as $role) {
            Role::create([
                'role' => $role['role'],
                'role_description' => $role['description']
            ]);
        }
    }
}

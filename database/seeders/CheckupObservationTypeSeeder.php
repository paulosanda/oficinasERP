<?php

namespace Database\Seeders;

use App\Models\CheckupObservationType;
use Illuminate\Database\Seeder;

class CheckupObservationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Freio dianteiro',
            'Freio traseiro',
            'Óleo do freio',
            'Óleo do motor',
            'Filtro de óleo',
            'Filtro de ar',
            'Filtro de ar condicionado',
            'Suspensão dianteira',
            'Suspensão traseira',
            'Barulho',
            'Luz painel',
            'Outros',
        ];

        foreach ($types as $type) {
            CheckupObservationType::create([
                'type' => $type,
            ]);
        }
    }
}

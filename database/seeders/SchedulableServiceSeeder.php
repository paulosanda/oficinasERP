<?php

namespace Database\Seeders;

use App\Models\SchedulableService;
use Illuminate\Database\Seeder;

class SchedulableServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Revisão preventiva',
            'Troca de óleo e filtro',
            'Troca de filtros de ar, combustível e cabine',
            'Verificação e troca de fluidos',
            'Verificação e troca de correias',
            'Verificação e troca de velas de ignição',
            'Inspeção e rotação dos pneus',
            'Alinhamento e balanceamento dos pneus',
            'Verificação dos freios',
            'Inspeção do sistema de suspensão e amortecedores',
            'Verificação da bateria e limpeza dos terminais',
            'Inspeção dos sistemas de iluminação',
            'Verificação do sistema de escape',
            'Verificação do sistema de ar condicionado',
            'Inspeção dos componentes do motor e transmissão',
        ];

        foreach ($services as $service) {
            SchedulableService::create([
                'service' => $service,
            ]);
        }
    }
}

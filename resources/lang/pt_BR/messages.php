<?php

use App\Models\Checkup;
use App\Models\Quote;

return [
    'quote-status' => [
        Quote::PENDING => 'Pendente',
        Quote::ACCEPTED => 'Aceito',
        Quote::REJECTED => 'Recusado',
        Quote::FINISH => 'Finalizado',

    ],

    'checkup-evaluation' => [
        Checkup::EVALUATION_PENDING => 'Pendente aprovação',
        Checkup::EVALUATION_APPROVED => 'Aprovado para uso',
        Checkup::EVALUATION_MAINTENANCE => 'Manutenção recomendada',
    ],
];

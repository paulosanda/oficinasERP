<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class CepGetAction
{
    public function __invoke(string $postalCode)
    {
        $postalCode = str_replace('-', '', trim($postalCode));

        if (strlen($postalCode) === 8) {
            return $this->getAddress($postalCode);

        } else {
            return false;
        }
    }

    private function getAddress(string $postalCode)
    {
        $url = env('CEP_API');
        $path = "/ws/$postalCode/json";

        $data = Http::get($url.$path)->json();

        if (! isset($data['erro'])) {
            return $data;
        } else {
            return false;
        }
    }
}

<?php

namespace App\Trait;

use App\Actions\CepGetAction;

trait RequestAddress
{
    public function requestAddress(): void
    {
        $cepGet = new CepGetAction();
        $response = $cepGet($this->postal_code);
        if ($response) {
            $this->address = $response['logradouro'];
            $this->neighborhood = $response['bairro'];
            $this->city = $response['localidade'];
            $this->state = $response['uf'];
        } else {
            session()->flash('error', 'CEP não encontrado!');
        }
    }
}

<?php

namespace App\Trait;

use Illuminate\Support\Facades\Auth;

trait CustomerBelongToClient
{
    public function checkCustomerClient($customerClientId)
    {
        $user = Auth::user();

        return $user->client->id == $customerClientId;
    }
}

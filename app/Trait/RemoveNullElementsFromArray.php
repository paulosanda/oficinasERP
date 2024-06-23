<?php

namespace App\Trait;

trait RemoveNullElementsFromArray
{
    public function removeNull($array): array
    {
        return array_filter($array, function ($value) {
            return $value !== null;
        });
    }
}

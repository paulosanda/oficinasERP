<?php

namespace App\Trait;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

trait EmptyEntity
{
    /**
     * @throws \Throwable
     */
    public function isEmpty($data, $property): void
    {
        throw_if(is_null ($data), ValidationException::withMessages(['error'=> $property])->status(Response::HTTP_UNPROCESSABLE_ENTITY));

    }
}

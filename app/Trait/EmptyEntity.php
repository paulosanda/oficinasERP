<?php

namespace App\Trait;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Throwable;
use function PHPUnit\Framework\isEmpty;

trait EmptyEntity
{
    /**
     * Verifica se a entidade está vazia e lança uma exceção se estiver.
     *
     * @param string $model O nome da classe do modelo.
     * @param string $field O nome do campo usado na consulta.
     * @param mixed $value O valor do campo usado na consulta.
     *
     * @throws Throwable
     * /
     * //    public function isEmpty($data, $property): void
* //    {
* //        throw_if(is_null ($data), ValidationException::withMessages(['error'=> $property])->status(Response::HTTP_UNPROCESSABLE_ENTITY));
* //
* //    }
 *
* /**
     * @throws Throwable
     */
    public function isEmpty($model, $field, $value): void
    {
        $entity = $model::where($field, $value)->first();

        if (!$entity->id) {
            throw ValidationException::withMessages(['error' => 'Empty entity for ' . $field])
                ->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

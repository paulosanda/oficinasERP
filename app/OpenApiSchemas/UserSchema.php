<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Dados do usuário",
 *     @OA\Property(property="id", type="integer", description="ID do usuário"),
 *     @OA\Property(property="name", type="string", description="Nome do usuário"),
 *     @OA\Property(property="email", type="string", description="Email do usuário"),
 *     @OA\Property(property="roles", type="array", @OA\Items(ref="#/components/schemas/Role")),
 * )
 */
class UserSchema
{}

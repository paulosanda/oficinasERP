<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Role",
 *     title="Role",
 *     description="Dados da função do usuário",
 *
 *     @OA\Property(property="id", type="integer", description="ID da função"),
 *     @OA\Property(property="role", type="string", description="Função do usuário"),
 *     @OA\Property(property="type", type="string", description="Tipo da função"),
 *     @OA\Property(property="role_description", type="string", description="Descrição da função"),
 * )
 */
class RolesSchema {}

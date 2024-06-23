<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Dados do usuário",
 *
 *     @OA\Property(property="id", type="integer", description="ID do usuário"),
 *     @OA\Property(property="name", type="string", description="Nome do usuário"),
 *     @OA\Property(property="email", type="string", description="Email do usuário"),
 *     @OA\Property(property="enable", type="boolean", description="usuário ativo", example="true"),
 *     @OA\Property(property="roles", type="array", @OA\Items(ref="#/components/schemas/Role")),
 * )
 */
class UserSchema {}

/**
 * @OA\Schema(
 *     schema="UserUpdate",
 *     title="UserUpdate",
 *     description="Dados para update de User, somente devem ser enviados no request os dados que serão alterados os demais devem ser null",
 *
 *     @OA\Property(property="name", type="string",nullable=true, description="nome do usuário para update"),
 *     @OA\Property(property="email", type="string", nullable=true, description="email do usuário para update"),
 *     @OA\Property(property="enable", type="boolean", nullable=true, description="true para usuário ativo, false para bloquear"),
 *     @OA\Property(property="password", type="string", nullable=true, description="novo password em caso de alteração"),
 *     @OA\Property(
 *          property="roles",
 *          type="array",
 *          nullable=true,
 *          description="novas roles para o usuário ou null se não houver mudança,somente as novas serão implementadas, as anteriores serão deletedas",
 *
 *          @OA\Items(ref="#/components/schemas/Role")
 *     )
 * )
 */
class UserUpdateSchema {}

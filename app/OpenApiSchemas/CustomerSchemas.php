<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="Customer",
 *     description="dados do customer(cliente das empresas)",
 *     @OA\Property(property="id", type="integer", format="int64", description="id do customer"),
 *     @OA\Property(property="name", type="string", description="nome do customer"),
 *     @OA\Property(property="email" type="string", description="email do customer),
 *     @OA\Property(property="celular", type="string", description="celular do customer)
 *     @OA\Property(property="telefone", type="string", description="telefone do customer"),
 *     @OA\Property(property="cpf", type="string", description="cpf do customer"),
 *     @OA\Property(property="nascimento", type="string", description="data de nascimento do customer"),
 *     @OA\Property(property="endereco", type="string", description="endereco do customer"),
 *     @OA\Property(property="numero", type="string", description="numero do endereço do customer"),
 *     @OA\Property(property="bairro", type="string", decription="bairro do customer"),
 *     @OA\Property(property="cidade", type="string", description="cidade do customer"),
 *     @OA\Property(property="estado", type="string", description="estado do customer"),
 * )
 */
class CustomerSchemas
{}

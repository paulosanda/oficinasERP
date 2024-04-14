<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     title="Customer",
 *     required={"name"},
 *     description="dados do customer",
 *     @OA\Property(property="name", type="string", description="nome do customer"),
 *     @OA\Property(property="email", type="string", nullable=true,description="email do customer"),
 *     @OA\Property(property="celular", type="string",nullable=true, description="celular do customer"),
 *     @OA\Property(property="telefone", type="string", nullable=true, description="telefone do customer"),
 *     @OA\Property(property="cpf", type="string",nullable=true, description="cpf do customer"),
 *     @OA\Property(property="nascimento", type="string",nullable=true, description="data de nascimento do customer"),
 *     @OA\Property(property="profissao", type="string", nullable=true, description="ocupação do customer"),
 *     @OA\Property(property="endereco", type="string",nullable=true, description="endereco do customer"),
 *     @OA\Property(property="numero", type="string", nullable=true,description="numero do endereço do customer"),
 *     @OA\Property(property="bairro", type="string",nullable=true, description="bairro do customer"),
 *     @OA\Property(property="cidade", type="string", nullable=true,description="cidade do customer"),
 *     @OA\Property(property="estado", type="string",nullable=true, description="estado do customer"),
 * )
 */

class CustomerSchemas
{}



/**
 * @OA\Schema(
 *     schema="CustomerUpdate",
 *     title="CustomerUpdate",
 *     required={"name"},
 *     description="dados do customer",
 *     @OA\Property(property="id", type="integer", description="id do customer"),
 *     @OA\Property(property="name", type="string", description="nome do customer"),
 *     @OA\Property(property="email", type="string", nullable=true,description="email do customer"),
 *     @OA\Property(property="celular", type="string",nullable=true, description="celular do customer"),
 *     @OA\Property(property="telefone", type="string", nullable=true, description="telefone do customer"),
 *     @OA\Property(property="cpf", type="string",nullable=true, description="cpf do customer"),
 *     @OA\Property(property="nascimento", type="string",nullable=true, description="data de nascimento do customer"),
 *     @OA\Property(property="profissao", type="string", nullable=true, description="ocupação do customer"),
 *     @OA\Property(property="endereco", type="string",nullable=true, description="endereco do customer"),
 *     @OA\Property(property="numero", type="string", nullable=true,description="numero do endereço do customer"),
 *     @OA\Property(property="bairro", type="string",nullable=true, description="bairro do customer"),
 *     @OA\Property(property="cidade", type="string", nullable=true,description="cidade do customer"),
 *     @OA\Property(property="estado", type="string",nullable=true, description="estado do customer"),
 * )
 */
class UpdateCustomerSchemas
{}

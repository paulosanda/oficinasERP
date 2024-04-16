<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Company",
 *     title="Company",
 *     description="dados do company",
 *     required={"razao_social", "cnpj","endereco","numero","bairro","cep","cidade","estado","celular","email"},
 *     @OA\Property(property="razao_social", type="string", description="razão social"),
 *     @OA\Property(property="cnpj", type="string", description="cnpj do company"),
 *     @OA\Property(property="inscricao_estadual",type="string",nullable=true,description="inscrição estadual do company"),
 *     @OA\Property(property="inscricao_municipal",type="string",nullable=true,description="inscrição municipal do company"),
 *     @OA\Property(property="endereco",type="string",description="endereço"),
 *     @OA\Property(property="numero", type="string",description="numero"),
 *     @OA\Property(property="bairro",type="string", description="bairro"),
 *     @OA\Property(property="cep",type="string",description="cep"),
 *     @OA\Property(property="cidade",type="string",description="cidade"),
 *     @OA\Property(property="estado",type="string",description="estado"),
 *     @OA\Property(property="celular",type="string",description="celular"),
 *     @OA\Property(property="email", type="string", description="email"),
 * )
 */
class CompanySchema
{}

/**
 * @OA\Schema(
 *     schema="CompanyUpdate",
 *     title="CompanyUpdate",
 *     description="dados do company",
 *     required={"id"},
 *     @OA\Property(property="id", type="integer", format="int64", description="id do company"),
 *     @OA\Property(property="razao_social", type="string", description="razão social"),
 *     @OA\Property(property="cnpj", type="string", description="cnpj do company"),
 *     @OA\Property(property="inscricao_estadual",type="string",nullable=true,description="inscrição estadual do company"),
 *     @OA\Property(property="inscricao_municipal",type="string",nullable=true,description="inscrição municipal do company"),
 *     @OA\Property(property="endereco",type="string",description="endereço"),
 *     @OA\Property(property="numero", type="string",description="numero"),
 *     @OA\Property(property="bairro",type="string", description="bairro"),
 *     @OA\Property(property="cep",type="string",description="cep"),
 *     @OA\Property(property="cidade",type="string",description="cidade"),
 *     @OA\Property(property="estado",type="string",description="estado"),
 *     @OA\Property(property="celular",type="string",description="celular"),
 *     @OA\Property(property="email", type="string", description="email"),
 * )
 */
class CompanyUpdateSchema
{}

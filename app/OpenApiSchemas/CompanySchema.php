<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="BodyRequestCompany",
 *     title="BodyRequestCompany",
 *     description="dados do company",
 *     required={"company_name", "cnpj","address","number","neighborhood","postal_code","city","state","cellphone","email"},
 *
 *     @OA\Property(property="company_name", type="string", description="razão social"),
 *     @OA\Property(property="cnpj", type="string", description="cnpj do company"),
 *     @OA\Property(property="inscricao_estadual",type="string",nullable=true,description="inscrição estadual do company"),
 *     @OA\Property(property="inscricao_municipal",type="string",nullable=true,description="inscrição municipal do company"),
 *     @OA\Property(property="address",type="string",description="endereço"),
 *     @OA\Property(property="number", type="string",description="number"),
 *     @OA\Property(property="neighborhood",type="string", description="neighborhood"),
 *     @OA\Property(property="postal_code",type="string",description="postal_code"),
 *     @OA\Property(property="city",type="string",description="city"),
 *     @OA\Property(property="state",type="string",description="state"),
 *     @OA\Property(property="cellphone",type="string",description="cellphone"),
 *     @OA\Property(property="email", type="string", description="email"),
 *     @OA\Property(property="logo", type="string", description="logo.png", format="binary"),
 * )
 */
class CompanySchema {}

/**
 * @OA\Schema(
 *     schema="Company",
 *     title="Company",
 *     description="dados do company",
 *     required={"id"},
 *
 *     @OA\Property(property="id", type="integer", format="int64", description="id do company"),
 *     @OA\Property(property="logo", type="string", description="logo.png"),
 *     @OA\Property(property="company_name", type="string", description="razão social"),
 *     @OA\Property(property="cnpj", type="string", description="cnpj do company"),
 *     @OA\Property(property="inscricao_estadual",type="string",nullable=true,description="inscrição estadual do company"),
 *     @OA\Property(property="inscricao_municipal",type="string",nullable=true,description="inscrição municipal do company"),
 *     @OA\Property(property="address",type="string",description="endereço"),
 *     @OA\Property(property="number", type="string",description="number"),
 *     @OA\Property(property="neighborhood",type="string", description="neighborhood"),
 *     @OA\Property(property="postal_code",type="string",description="postal_code"),
 *     @OA\Property(property="city",type="string",description="city"),
 *     @OA\Property(property="state",type="string",description="state"),
 *     @OA\Property(property="cellphone",type="string",description="cellphone"),
 *     @OA\Property(property="email", type="string", description="email"),
 *     @OA\Property(property="users", type="array", @OA\Items(ref="#/components/schemas/User"))
 * )
 */
class CompanyUpdateSchema {}

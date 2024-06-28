<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="ERP para oficinas e afins",
 *     description="Platarforma para administração de oficinas e afins",
 *     version="1.0.0",
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 *  )
 */
abstract class Controller
{
    //
}

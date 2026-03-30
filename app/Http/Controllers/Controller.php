<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *   title="MediVault API",
 *   version="1.0.0",
 *   description="Digital Medical Record Management System for Indian users",
 *   @OA\Contact(email="support@medivault.in")
 * )
 * @OA\SecurityScheme(
 *   securityScheme="sanctum",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="Token"
 * )
 * @OA\Server(url="/", description="MediVault API Server")
 */
abstract class Controller
{
    //
}

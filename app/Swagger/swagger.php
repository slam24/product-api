<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Products API",
 *         description="API para gestión de productos y divisas con Laravel y arquitectura hexagonal",
 *         @OA\Contact(
 *             email="support@example.com"
 *         ),
 *         @OA\License(
 *             name="MIT",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000/api/v1",
 *         description="API Server"
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000/api/v1",
 *         description="Local Server"
 *     ),
 *     @OA\ExternalDocumentation(
 *         description="Documentación del proyecto",
 *         url="https://github.com/tu-usuario/products-api"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="bearerAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT"
 *         ),
 *         @OA\Schema(
 *             schema="Product",
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Producto 1"),
 *             @OA\Property(property="description", type="string", example="Descripción del producto"),
 *             @OA\Property(property="price", type="number", format="float", example=100.50),
 *             @OA\Property(property="currency_id", type="integer", example=1),
 *             @OA\Property(property="tax_cost", type="number", format="float", example=10.5),
 *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=50.0),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         ),
 *         @OA\Schema(
 *             schema="Currency",
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Dólar"),
 *             @OA\Property(property="symbol", type="string", example="$"),
 *             @OA\Property(property="exchange_rate", type="number", format="float", example=1.0),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     )
 * )
 */
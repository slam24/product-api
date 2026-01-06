<?php

namespace App\Infrastructure\Http\Controllers;

use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Application\UseCases\Product\CreateProductUseCase;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for managing products"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ProductController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private CreateProductUseCase $createUseCase
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="Get list of all products",
     *     @OA\Response(
     *         response=200,
     *         description="List of products",
     *         security={{"bearerAuth":{}}},
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="price", type="number", format="float"),
     *                 @OA\Property(property="currency_id", type="integer"),
     *                 @OA\Property(property="tax_cost", type="number", format="float"),
     *                 @OA\Property(property="manufacturing_cost", type="number", format="float")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->repository->all());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="Create a new product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","description","price","currency_id","tax_cost","manufacturing_cost"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="currency_id", type="integer"),
     *             @OA\Property(property="tax_cost", type="number", format="float"),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Product created successfully"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'currency_id' => 'required|exists:currencies,id',
            'tax_cost' => 'required|numeric',
            'manufacturing_cost' => 'required|numeric',
        ]);

        return response()->json(
            $this->createUseCase->execute($data),
            201
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Get a product by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="currency_id", type="integer"),
     *             @OA\Property(property="tax_cost", type="number", format="float"),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function show($id)
    {
        return response()->json($this->repository->find($id));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Update a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="currency_id", type="integer"),
     *             @OA\Property(property="tax_cost", type="number", format="float"),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Product updated successfully"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function update(Request $request, $id)
    {
        return response()->json(
            $this->repository->update($id, $request->all())
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Product deleted successfully"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Deleted']);
    }
}
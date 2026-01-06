<?php

namespace App\Infrastructure\Http\Controllers;

use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Repositories\ProductPriceRepositoryInterface;
use App\Application\UseCases\ProductPrice\CreateProductPriceUseCase;

/**
 * @OA\Tag(
 *     name="Product Prices",
 *     description="API Endpoints for managing product prices"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ProductPriceController extends Controller
{
    public function __construct(
        private ProductPriceRepositoryInterface $repository,
        private CreateProductPriceUseCase $createUseCase
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/products/{productId}/prices",
     *     tags={"Product Prices"},
     *     summary="Get all prices for a product",
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of product prices",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="product_id", type="integer"),
     *                 @OA\Property(property="currency_id", type="integer"),
     *                 @OA\Property(property="price", type="number", format="float")
     *             )
     *         )
     *     )
     * )
     */
    public function index($productId)
    {
        return response()->json($this->repository->all($productId));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/products/{productId}/prices",
     *     tags={"Product Prices"},
     *     summary="Create a new price for a product",
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"currency_id","price"},
     *             @OA\Property(property="currency_id", type="integer"),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Price created successfully"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function store(Request $request, $productId)
    {
        $data = $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'price' => 'required|numeric',
        ]);

        $data['product_id'] = $productId;

        return response()->json(
            $this->createUseCase->execute($data),
            201
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/products/{productId}/prices/{priceId}",
     *     tags={"Product Prices"},
     *     summary="Delete a price for a product",
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="priceId",
     *         in="path",
     *         description="ID of the price to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Price deleted successfully"),
     *     @OA\Response(response=404, description="Price not found")
     * )
     */
    public function destroy($productId, $priceId)
    {
        $this->repository->delete($priceId);
        return response()->json(['message' => 'Deleted']);
    }
}
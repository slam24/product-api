<?php

namespace App\Infrastructure\Http\Controllers;

use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Repositories\CurrencyRepositoryInterface;
use App\Application\UseCases\Currency\CreateCurrencyUseCase;

/**
 * @OA\Tag(
 *     name="Currencies",
 *     description="Endpoints para gestionar divisas"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class CurrencyController extends Controller
{
    public function __construct(
        private CurrencyRepositoryInterface $repository,
        private CreateCurrencyUseCase $createUseCase
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/currencies",
     *     tags={"Currencies"},
     *     summary="Listar todas las divisas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de divisas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Currency")
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
     *     path="/api/v1/currencies",
     *     tags={"Currencies"},
     *     summary="Crear una nueva divisa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","symbol","exchange_rate"},
     *             @OA\Property(property="name", type="string", example="Euro"),
     *             @OA\Property(property="symbol", type="string", example="€"),
     *             @OA\Property(property="exchange_rate", type="number", format="float", example=1.2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Divisa creada",
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validación fallida"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'symbol' => 'required|string',
            'exchange_rate' => 'required|numeric',
        ]);

        return response()->json(
            $this->createUseCase->execute($data),
            201
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/currencies/{id}",
     *     tags={"Currencies"},
     *     summary="Obtener una divisa por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la divisa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Divisa encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Divisa no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json($this->repository->find($id));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/currencies/{id}",
     *     tags={"Currencies"},
     *     summary="Actualizar una divisa por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la divisa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Euro"),
     *             @OA\Property(property="symbol", type="string", example="€"),
     *             @OA\Property(property="exchange_rate", type="number", format="float", example=1.2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Divisa actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validación fallida"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Divisa no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'symbol' => 'sometimes|string',
            'exchange_rate' => 'sometimes|numeric',
        ]);

        return response()->json(
            $this->repository->update($id, $data)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/currencies/{id}",
     *     tags={"Currencies"},
     *     summary="Eliminar una divisa por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la divisa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Divisa eliminada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Divisa no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Deleted']);
    }
}
<?php

namespace Project4\Controller;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Repository\CategoriesRepository;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FindCategoriesController
{
    private CategoriesRepository $categoriesRepository;

    public function __construct(Container $container)
    {
        $this->categoriesRepository = $container->get(CategoriesRepository::class);
    }

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     description="Returns a category by ID.",
     *     tags={"Categories"},
     *      @OA\Parameter(
     *         description="ID of Category to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post response",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryResponse")
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $category = $this->categoriesRepository->findCategory(Uuid::fromString($args['id']));
        return new JsonResponse(CategoryResponse::fromCategory($category));
    }
}
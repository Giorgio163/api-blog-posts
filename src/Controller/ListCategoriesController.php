<?php

namespace Project4\Controller;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Repository\CategoriesRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListCategoriesController
{
    private CategoriesRepository $categoriesRepository;

    public function __construct(Container $container)
    {
        $this->categoriesRepository = $container->get(CategoriesRepository::class);
    }

    /**
     * @OA\Get(
     *     path="/categories/listAllCategories",
     *     description="Returns all Categories.",
     *     tags={"Categories"},
     * @OA\Response(
     *         response=200,
     *         description="Categories response",
     * @OA\JsonContent(
     *              type="array",
     * @OA\Items(ref="#/components/schemas/CategoryResponse")
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $categories = $this->categoriesRepository->findAllCategories();
        return $this->toJson($categories);
    }

    private function toJson(array $categories): JsonResponse
    {
        $response = [];
        foreach ($categories as $category) {
            $response[] = [
                'id' => $category->id()->toString(),
                'name' => $category->name(),
                'description' => $category->description(),
            ];
        }

        return new JsonResponse($response);
    }
}

<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Entity\Categories;
use Project4\Repository\CategoriesRepository;
use Project4\Validator\CategoryValidator;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateCategoriesController
{
    private CategoriesRepository $categoriesRepository;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->categoriesRepository = $container->get(CategoriesRepository::class);
    }

    /**
     * @OA\Post(
     *     path="/categories/create",
     *     description="Create a new category",
     *     tags={"Categories"},
     * @OA\RequestBody(
     *         description="Category to be created",
     *         required=true,
     * @OA\MediaType(
     *              mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(property="name",        type="string", example="Example: Food"),
     * @OA\Property(property="description", type="string", example="It is a food category"),
     *      )
     *    )
     * ),
     * @OA\Response(
     *     response="200",
     *     description="The ID of the category",
     * @OA\MediaType(
     *           mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(property="id",          type="string", example="115ec074-2a37-40ba-a51c-33d2efab684c"),
     *       )
     *     )
     *   )
     * )
     * @throws                              \JsonException
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $inputs = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        CategoryValidator::validate($inputs);

        $category = new Categories(Uuid::uuid4(), $inputs['name'], $inputs['description']);
        $this->categoriesRepository->storeCategories($category);

        $output = [
            ...$inputs,
        ];

        return new JsonResponse($output);
    }
}

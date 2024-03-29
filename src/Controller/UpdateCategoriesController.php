<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Repository\CategoriesRepository;
use Project4\Validator\CategoryValidator;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdateCategoriesController
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
     * @OA\Put(
     *     path="/categories/{id}",
     *     description="Update a Category by ID.",
     *     tags={"Categories"},
     * @OA\Parameter(
     *         description="ID of Category to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     * @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\RequestBody(
     *          description="Category to be inserted.",
     *          required=true,
     * @OA\MediaType(
     *              mediaType="application/json",
     * @OA\Schema(ref="#/components/schemas/UpdateCategoriesResponse")
     *          )
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="The ID of the Category"
     *     )
     * )
     * @throws                                                         \JsonException
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $data = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        CategoryValidator::validate($data);

        $this->categoriesRepository->updateCategory(Uuid::fromString($args['id']), $data);

        $output = [
            'status' => 'success',
            'data' => [ 'id' => $args['id'] ]
        ];

        return new JsonResponse($output);
    }
}

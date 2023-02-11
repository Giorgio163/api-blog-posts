<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Entity\PostsCategories;
use Project4\Repository\PostsCategoriesRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FindPostsCategoriesController
{
    private PostsCategoriesRepository $postsCategoriesRepository;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->postsCategoriesRepository = $container->get(PostsCategoriesRepository::class);
    }

    /**
     * @OA\Get(
     *     path="/PostsCategories/{id_post}",
     *     description="Returns a PostCategory by ID.",
     *     tags={"PostsCategories"},
     *      @OA\Parameter(
     *         description="ID of Post to fetch",
     *         in="path",
     *         name="id_post",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PostCategory response",
     *         @OA\JsonContent(ref="#/components/schemas/PostsCategoryResponse")
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $postCategory = $this->postsCategoriesRepository->find($args['id_post']);
        return new JsonResponse($postCategory);
    }
}
<?php

namespace Project4\Controller;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Repository\PostsRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FindPostController
{
    private PostsRepository $postsRepository;

    public function __construct(Container $container)
    {
        $this->postsRepository = $container->get(PostsRepository::class);
    }

    /**
     * @OA\Get(
     *     path="/posts/{id}",
     *     description="Returns a Post by ID.",
     *     tags={"Posts"},
     *      @OA\Parameter(
     *         description="ID of Post to fetch",
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
     *         @OA\JsonContent(ref="#/components/schemas/PostResponse")
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $post = $this->postsRepository->find(Uuid::fromString($args['id']));
        return new JsonResponse(PostsResponse::fromPost($post));
    }
}
<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Repository\PostsRepository;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdatePostController
{
    private PostsRepository $postsRepository;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->postsRepository = $container->get(PostsRepository::class);
    }

    /**
     * @OA\Put(
     *     path="/post/update/{id}",
     *     description="Update a student by ID.",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         description="ID of Post to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *          description="Post to be inserted.",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Post")
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="The ID of the Post"
     *     )
     * )
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $id = $this->postsRepository->update(Uuid::fromString($args['id']));

        $res = [
            'status' => 'success',
            'data' => [ 'id' => $id ]
        ];

        return new JsonResponse($res, 200);
    }
}
<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use PDOException;
use Project4\Repository\PostsRepository;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeletePostController
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
     * @OA\Delete(
     *     path="/post/{id}",
     *     description="Delete a post by ID.",
     *     tags={"Posts"},
     * @OA\Parameter(
     *         description="ID of post to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     * @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="The ID of the post"
     *     )
     * )
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        try {
            $id = $this->postsRepository->delete(Uuid::fromString($args['id']));

            $res = [
                'status' => 'success',
                'data' => [ 'id' => $id ]
            ];

            return new JsonResponse($res, 200);
        } catch (PDOException $e) {
            error_log($e);
            $res = [
                'status' => 'error',
                'message' => 'Cannot delete a Post that is present in a Category'
            ];

            return new JsonResponse($res, 500);
        }
    }
}

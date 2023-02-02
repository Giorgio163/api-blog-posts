<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Entity\Posts;
use Project4\Repository\PostsRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreatePostsController
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
     * @OA\Post(
     *     path="/posts/create",
     *     description="Create a new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         description="Post to be created",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="title", type="string", example="Excellent work"),
     *                  @OA\Property(property="slug", type="string", example="Yes it is"),
     *                  @OA\Property(property="content", type="string", example="Look Here"),
     *                  @OA\Property(property="thumbnail", type="string", example="photo.png"),
     *                  @OA\Property(property="author", type="string", example="Giorgio Selmi"),
     *                  @OA\Property(property="posted_at", type="string", example="2023-02-03"),
     *      )
     *    )
     * ),
     * @OA\Response(
     *     response="200",
     *     description="The ID of the post",
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              @OA\Property(property="id", type="string", example="115ec074-2a37-40ba-a51c-33d2efab684c"),
     *       )
     *     )
     *   )
     * )
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
       $inputs = json_decode($request->getBody()->getContents(), true);

       $post = new Posts(Uuid::uuid4(), $inputs['title'], $inputs['slug'], $inputs['content'],
                $inputs['thumbnail'], $inputs['author'], $inputs['posted_at']);
       $this->postsRepository->storePost($post);

       $output = [
           ...$inputs,
       ];

       return new JsonResponse($output);
    }
}
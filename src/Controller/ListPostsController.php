<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use Project4\Entity\Posts;
use Project4\Repository\PostsRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Annotations as OA;

class ListPostsController
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
     * @OA\Get(
     *     path="/posts/listAll",
     *     description="Returns all Posts.",
     *     tags={"Posts"},
     * @OA\Response(
     *         response=200,
     *         description="Posts response",
     * @OA\JsonContent(
     *              type="array",
     * @OA\Items(ref="#/components/schemas/PostResponse")
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $posts = $this->postsRepository->findAll();
        return $this->toJson($posts);
    }

    /**
     *
     *
     * @param Posts[] $posts
     */
    private function toJson(array $posts): JsonResponse
    {
        $response = [];
        foreach ($posts as $post) {
            $response[] = [
                'id' => $post->id()->toString(),
                'title' => $post->title(),
                'slug' => $post->slug(),
                'content' => $post->content(),
                'thumbnail' => $post->thumbnail(),
                'author' => $post->author(),
                'posted_at' => $post->posted_at(),

            ];
        }

        return new JsonResponse($response);
    }
}

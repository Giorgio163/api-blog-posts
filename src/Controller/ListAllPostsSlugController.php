<?php

namespace Project4\Controller;

use Cocur\Slugify\Slugify;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Entity\Posts;
use Project4\Repository\PostsRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListAllPostsSlugController
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
     *     path="/posts/listAllBySlug/{slug}",
     *     description="Returns a Post by slug.",
     *     tags={"Posts"},
     * @OA\Parameter(
     *         description="Slug of Post to fetch",
     *         in="path",
     *         name="slug",
     *         required=true,
     * @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Response(
     *         response=200,
     *         description="Post response",
     * @OA\JsonContent(ref="#/components/schemas/PostResponse")
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $posts = $this->postsRepository->findBySlug($args['slug']);
        return $this->toJson($posts);
    }

    /**
     *
     *
     * @param Posts[] $posts
     */
    private function toJson(array $posts): JsonResponse
    {
        $postsCategories = [];
        foreach ($posts as $post) {
            $postsCategories[] = $post->toArray();
        }
        return new JsonResponse($postsCategories);
    }
}

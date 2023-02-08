<?php

namespace Project4\Controller;

use Cocur\Slugify\Slugify;
use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Entity\Posts;
use Project4\Repository\PostsRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListAllPostsSlugController
{
    private PostsRepository $postsRepository;

    public function __construct(Container $container)
    {
        $this->postsRepository = $container->get(PostsRepository::class);
    }

    /**
     * @OA\Get(
     *     path="/posts/listAllBySlug",
     *     description="Returns all Posts by Slug.",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Posts response",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/PostResponse")
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $posts = $this->postsRepository->findAll();
        return $this->toJson($posts);
    }

    /** @param Posts[] $posts */
    private function toJson(array $posts): JsonResponse
    {
        $slugify = new Slugify(["separator" => "__"]);

        $response = [];
        foreach ($posts as $post) {
            $response[] = [
                'id' => $post->id()->toString(),
                'title' => $post->title(),
                'slug' => $slugify->slugify($post->slug()),
                'content' => $post->content(),
                'thumbnail' => $post->thumbnail(),
                'author' => $post->author(),
                'posted_at' => $post->posted_at()
            ];
        }

        return new JsonResponse($response);
    }
}
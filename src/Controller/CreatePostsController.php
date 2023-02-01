<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
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
        $this->postsRepository = $container->get('posts-repository');
    }

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
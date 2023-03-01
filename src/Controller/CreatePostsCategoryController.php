<?php

namespace Project4\Controller;

use Cocur\Slugify\Slugify;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use Project4\Entity\Posts;
use Project4\Validator\PostValidator;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Project4\Repository\CategoriesRepository;
use Project4\Repository\PostsRepository;

class CreatePostsCategoryController
{
    private CategoriesRepository $categoriesRepository;
    private  PostsRepository $postsRepository;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->categoriesRepository = $container->get(CategoriesRepository::class);
        $this->postsRepository = $container->get(PostsRepository::class);
        $this->base = $container->get('settings')['app']['domain'];
    }

    public function __invoke(Request $request, Response $response, $args): JsonResponse {

        $jsonParams = json_decode($request->getBody()->getContents(), true);

        PostValidator::validate($jsonParams);
        $slugify = new Slugify();
        $slug = $slugify->slugify($jsonParams['title']);

        $id = uniqid();
        $b64 = $jsonParams['thumbnail'];
        file_put_contents('images/'. $id . '.jpg', base64_decode($b64));

        $post = new Posts(
            Uuid::uuid4(), $jsonParams['title'], $slug, $jsonParams['content'],
            $this->base . '/images/' . $id . '.jpg', $jsonParams['author']
        );

        foreach ($jsonParams['categoryId'] as $categoryId) {
            $category = $this->categoriesRepository->category($categoryId);
            if ($category === null) {
                throw new \InvalidArgumentException('Category not found');
            }
            $post->addCategory($category);
        }

        $this->postsRepository->store($post);


        return new jsonResponse($post->toArray(), 201);
    }
}

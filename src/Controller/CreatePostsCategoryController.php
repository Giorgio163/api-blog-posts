<?php

namespace Project4\Controller;

use Cocur\Slugify\Slugify;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use http\Exception\InvalidArgumentException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Entity\Posts;
use Project4\Validator\CategoryValidator;
use Project4\Validator\PostValidator;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Project4\Repository\CategoriesRepository;
use Project4\Repository\PostsRepository;

class CreatePostsCategoryController
{
    private CategoriesRepository $categoriesRepository;
    private PostsRepository $postsRepository;
    private string $base;

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

    /**
     * @OA\Post(
     *     path="/posts/create",
     *     description="Create a new post",
     *     tags={"Posts"},
     * @OA\RequestBody(
     *         description="Post to be created",
     *         required=true,
     * @OA\MediaType(
     *              mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(property="title",      type="string", example="Excellent work"),
     * @OA\Property(property="content",    type="string", example="Look Here"),
     * @OA\Property(property="thumbnail",  type="string", example="photo from Base64Encoder"),
     * @OA\Property(property="author",     type="string", example="Giorgio Selmi"),
     * @OA\Property(property="postedAt",  type="string", example="2023-02-03"),
     * @OA\Property(property="categoryId", type="string", example="[7b2f8bee-cc6d-40f2-92c2-e001f3b08019]"),
     *      )
     *    )
     * ),
     * @OA\Response(
     *     response="200",
     *     description="The ID of the post",
     * @OA\MediaType(
     *           mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(property="id",         type="string", example="115ec074-2a37-40ba-a51c-33d2efab684c"),
     *       )
     *     )
     *   )
     * )
     * @throws                             \JsonException
     */

    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {

        $jsonParams = json_decode(
            $request->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        CategoryValidator::validateCategoryId($jsonParams['categoryId']);
        PostValidator::validate($jsonParams);
        $slugify = new Slugify();
        $slug = $slugify->slugify($jsonParams['title']);

        $id = uniqid('', true);
        $b64 = $jsonParams['thumbnail'];
        file_put_contents('images/' . $id . '.jpg', base64_decode($b64));

        $post = new Posts(
            Uuid::uuid4(),
            $jsonParams['title'],
            $slug,
            $jsonParams['content'],
            $this->base . '/images/' . $id . '.jpg',
            $jsonParams['author']
        );

        foreach ($jsonParams['categoryId'] as $categoryId) {
                $this->categoriesRepository->findCategory(Uuid::fromString($categoryId));
                $category = $this->categoriesRepository->category($categoryId);
                $post->addCategory($category);
        }

        $this->postsRepository->store($post);


        return new jsonResponse($post->toArray(), 201);
    }
}

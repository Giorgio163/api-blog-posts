<?php

namespace Project4\Controller;

use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Repository\PostsRepository;
use Project4\Validator\PostValidator;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdatePostController
{
    private PostsRepository $postsRepository;
    private string $base;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->postsRepository = $container->get(PostsRepository::class);
        $this->base = $container->get('settings')['app']['domain'];
    }

    /**
     * @OA\Put(
     *     path="/post/{id}",
     *     description="Update a Post by ID.",
     *     tags={"Posts"},
     * @OA\Parameter(
     *         description="ID of Post to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     * @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\RequestBody(
     *          description="Post to be inserted.",
     *          required=true,
     * @OA\MediaType(
     *              mediaType="application/json",
     * @OA\Schema(ref="#/components/schemas/UpdateResponse")
     *          )
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="The ID of the Post"
     *     )
     * )
     * @throws                                               \JsonException
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $inputs = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        PostValidator::validate($inputs);

        $slugify = new Slugify();
        $slug = $slugify->slugify($inputs['title']);

        $id = uniqid('', true);
        $b64 = $inputs['thumbnail'];
        file_put_contents('images/' . $id . '.jpg', base64_decode($b64));

        $data = [
            'title' => $inputs['title'],
            'slug' => $slug,
            'content' => $inputs['content'],
            'thumbnail' => $this->base . '/images/' . $id . '.jpg',
            'author' => $inputs['author'],
            'postedAt' => new DateTimeImmutable('now')
        ];

        $this->postsRepository->update(Uuid::fromString($args['id']), $data);

        $output = [
            'status' => 'success',
            'data' => [ 'id' => $args['id'] ]
        ];

        return new JsonResponse($output);
    }
}

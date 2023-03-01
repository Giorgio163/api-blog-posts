<?php
//
//namespace Project4\Controller;
//
//use DI\Container;
//use DI\DependencyException;
//use DI\NotFoundException;
//use Laminas\Diactoros\Response\JsonResponse;
//use OpenApi\Annotations as OA;
//use Project4\Entity\TOBEDELETEDPostsCategories;
//use Project4\Repository\TOBEDELETEDPostsCategoriesRepository;
//use Ramsey\Uuid\Uuid;
//use Slim\Psr7\Request;
//use Slim\Psr7\Response;
//
//class TOBEDELETEDCreatePostsCategoriesController
//{
//    private TOBEDELETEDPostsCategoriesRepository $postsCategoriesRepository;
//
//    /**
//     * @throws DependencyException
//     * @throws NotFoundException
//     */
//    public function __construct(Container $container)
//    {
//        $this->postsCategoriesRepository = $container->get(TOBEDELETEDPostsCategoriesRepository::class);
//    }
//
//    /**
//     * @OA\Post(
//     *     path="/PostsCategories/create",
//     *     description="Create a new category",
//     *     tags={"PostsCategories"},
//     * @OA\RequestBody(
//     *         description="PostsCategory to be created",
//     *         required=true,
//     * @OA\MediaType(
//     *              mediaType="application/json",
//     * @OA\Schema(
//     * @OA\Property(property="id_category", type="string", example="115ec074-2a37-40ba-a51c-33d2efab684c"),
//     * @OA\Property(property="id_post",     type="string", example="33d2efab684c-115ec074-2a37-40ba-a51c"),
//     *      )
//     *    )
//     * ),
//     * @OA\Response(
//     *     response="200",
//     *     description="The ID of the category",
//     * @OA\MediaType(
//     *           mediaType="application/json",
//     * @OA\Schema(
//     * @OA\Property(property="id_category", type="string", example="115ec074-2a37-40ba-a51c-33d2efab684c"),
//     * @OA\Property(property="id_post",     type="string", example="33d2efab684c-115ec074-2a37-40ba-a51c"),
//     *       )
//     *     )
//     *   )
//     * )
//     */
//
//    public function __invoke(Request $request, Response $response, $args): JsonResponse
//    {
//        $inputs = json_decode($request->getBody()->getContents(), true);
//
//        $PostsCategories = new TOBEDELETEDPostsCategories(Uuid::fromString($inputs['id_post']), Uuid::fromString($inputs['id_category']));
//        $this->postsCategoriesRepository->storePostsCategories($PostsCategories);
//
//        $output = [
//            ...$inputs,
//        ];
//
//        return new JsonResponse($output);
//    }
//}

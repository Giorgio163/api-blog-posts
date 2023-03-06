<?php

namespace Project4\Controller;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class JwtController
{
    /**
     * @OA\Post(
     *     path="/jwt",
     *     description="Generate JWT token",
     *     tags={"JWT"},
     * @OA\RequestBody(
     *         description="true or false",
     *         required=true,
     * @OA\MediaType(
     *              mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(property="admin",      type="string", example="true or false"),
     *      )
     *    )
     * ),
     * @OA\Response(
     *     response="200",
     *     description="The token to authenticate",
     * @OA\MediaType(
     *           mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(property="admin",  type="string",
     *      example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
     * eyJzdWIiOiIwMDAwMDAwMDEiLCJuYW1lIjoiR2lvcmdpbyIsImFkbWluIjp0cnVlLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMH0
     *     .bo1cScxW5l3CNyzqs9VdGnvLeQh1gVukI-vMNI4xJXo"),
     *       )
     *     )
     *   )
     * )
     * @throws                             \JsonException
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $params = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $payload = [
            'sub' => '000000001',
            'name' => 'Giorgio',
            'admin' => $params['admin'] ?? true,
            'iat' => 1356999524,
            'nbf' => 1357000000
        ];

        $jwt = JWT::encode($payload, $_ENV['JWT_SECRET']);

        return new JsonResponse(['token' => $jwt]);
    }
}

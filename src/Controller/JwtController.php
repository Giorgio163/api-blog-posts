<?php

namespace Project4\Controller;

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\JsonResponse;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class JwtController
{
    /**
     * @throws \JsonException
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

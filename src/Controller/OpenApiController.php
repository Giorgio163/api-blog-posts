<?php

namespace Project4\Controller;

use OpenApi\Generator;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(security={{"bearerAuth": {}}})
 * @OA\Info(title="Module               5 Project", version="2.0")
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class OpenApiController
{
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $openapi = Generator::scan([__DIR__ . '/../../src']);

        return new JsonResponse(json_decode($openapi->toJson()));
    }
}

<?php

namespace Project4\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController
{
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $data = ['app' => 'Module 5 Project', 'version' => '2.0'];
        return new JsonResponse($data);
    }
}
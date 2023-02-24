<?php

namespace Project4\Factory;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class OnlyAdminMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $token = $request->getAttribute('token');

        $isAdmin = isset($token['admin']) && $token['admin'] === true;
        if (! $isAdmin) {
            return new JsonResponse(['not authorized'], 401);
        }

        return $handler->handle($request);
    }
}

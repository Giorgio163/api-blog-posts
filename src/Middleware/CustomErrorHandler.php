<?php

namespace Project4\Middleware;

use Monolog\Logger;
use Project4\Exception\InvalidDataException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Throwable;
use Slim\Psr7\Request;
use Psr\Log\LoggerInterface;

class CustomErrorHandler
{
    private Logger $logger;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(private App $app)
    {
        $this->logger = $this->app->getContainer()->get('logger');
    }

    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ): ResponseInterface {
        $payload = $this->getPayload($exception);

        if ($displayErrorDetails) {
            $payload['details'] = $exception->getMessage();
        }

        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write(
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );

        return $response->withStatus($payload['status_code']);
    }
    private function getPayload(Throwable $exception): array
    {
        if ($exception instanceof InvalidDataException) {
            return [
                'errors' => $exception->getDataErrors(),
                'code' => 'validation_exception',
                'id' => 'invalid_data_exception',
                'status_code' => 400,
            ];
        }
        return [
            'error' => 'Oops... Something went wrong, please try again later.',
            'code' => 'internal_error',
            'status_code' => 500,
        ];
    }
}

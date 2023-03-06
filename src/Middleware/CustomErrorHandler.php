<?php

namespace Project4\Middleware;

use DI\NotFoundException;
use Monolog\Logger;
use Project4\Exception\InvalidDataException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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

    /**
     * @throws \JsonException
     */
    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ) {
        $payload = $this->getPayload($exception);

        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write(
            json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
        );

        return $response->withStatus($payload['status_code']);
    }
    private function getPayload(Throwable $exception): array
    {
        if ($exception instanceof InvalidDataException) {
            $this->logger->debug(json_encode($exception->getDataErrors(), JSON_THROW_ON_ERROR));
            return [
                'errors' => $exception->getDataErrors(),
                'code' => 'validation_exception',
                'id' => 'invalid_data_exception',
                'status_code' => 400,
            ];
        }

        if ($exception instanceof NotFoundException) {
            $this->logger->debug(json_encode($exception->getMessage(), JSON_THROW_ON_ERROR));
            return [
                'errors' => $exception->getMessage(),
                'code' => 'not found exception',
                'status_code' => 404,
            ];
        }
        $this->logger->error($exception->getMessage());
        return [
            'error' => $exception->getMessage(),
            'code' => 'internal server error',
            'status_code' =>  500,
        ];
    }
}

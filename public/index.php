<?php

use DI\Container;
use Laminas\Diactoros\Response\HtmlResponse;
use Project4\Controller\CreatePostsController;
use Project4\Controller\FindPostController;
use Project4\Controller\HomeController;
use Project4\Controller\ListPostsController;
use Project4\Controller\OpenApiController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../boot.php';

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get('/', HomeController::class);
$app->get('/openApi', OpenApiController::class);
$app->get('/posts/listAll', new ListPostsController($container));
$app->post('/posts/create', new CreatePostsController($container));
$app->get('/apidocs', fn () => new HtmlResponse(file_get_contents(__DIR__ . '/apidocs.html')));
$app->get('/posts/{id}', new FindPostController($container));

$app->addErrorMiddleware(true, true, true);

$app->run();
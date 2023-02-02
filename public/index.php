<?php

use DI\Container;
use Project4\Controller\CreatePostsController;
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

$app->addErrorMiddleware(true, true, true);

$app->run();
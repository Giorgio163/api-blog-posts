<?php

use DI\Container;
use Project4\Controller\CreatePostsController;
use Project4\Controller\HomeController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/container.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get('/', HomeController::class);
$app->post('/create', new CreatePostsController($container));

$app->addErrorMiddleware(true, true, true);

$app->run();
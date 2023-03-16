<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Project4\Controller\CreateCategoriesController;
use Project4\Controller\TOBEDELETEDCreatePostsCategoriesController;
use Project4\Controller\TOBEDELETEDCreatePostsController;
use Project4\Controller\DeleteCategoriesController;
use Project4\Controller\DeletePostController;
use Project4\Controller\FindCategoriesController;
use Project4\Controller\FindPostController;
use Project4\Controller\TOBEDELETEDFindPostsCategoriesController;
use Project4\Controller\HomeController;
use Project4\Controller\JwtController;
use Project4\Controller\ListAllPostsSlugController;
use Project4\Controller\ListCategoriesController;
use Project4\Controller\ListPostsController;
use Project4\Controller\OpenApiController;
use Project4\Controller\CreatePostsCategoryController;
use Project4\Controller\UpdateCategoriesController;
use Project4\Controller\UpdatePostController;
use Project4\Factory\JwtMiddlewareFactory;
use Project4\Factory\OnlyAdminMiddleware;
use Project4\Middleware\CustomErrorHandler;
use Slim\Factory\AppFactory;

require __DIR__ . '/../boot.php';

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$authMiddleware = JwtMiddlewareFactory::make();

// JWT
$app->post('/jwt', new JwtController());

// API
$app->get('/apidocs', fn () => new HtmlResponse(file_get_contents(__DIR__ . '/apidocs.html')));
$app->get('/openApi', OpenApiController::class);

// Homepage
$app->get('/', HomeController::class);

// Routes Posts
$app->get('/posts/all', new ListPostsController($container))->add(new OnlyAdminMiddleware())
    ->add($authMiddleware);
$app->get('/posts/by-slug/{slug}', new ListAllPostsSlugController($container))
    ->add(new OnlyAdminMiddleware())->add($authMiddleware);
$app->post('/posts/create', new CreatePostsCategoryController($container))->add(new OnlyAdminMiddleware())
    ->add($authMiddleware);
$app->get('/posts/{id}', new FindPostController($container))->add(new OnlyAdminMiddleware())
    ->add($authMiddleware);
$app->delete('/post/{id}',new DeletePostController($container))->add(new OnlyAdminMiddleware())
    ->add($authMiddleware);
$app->put('/post/{id}',new UpdatePostController($container))->add(new OnlyAdminMiddleware())
    ->add($authMiddleware);

// Routes Categories
$app->get('/categories/all', new ListCategoriesController($container))
    ->add(new OnlyAdminMiddleware())->add($authMiddleware);
$app->post('/categories/create', new CreateCategoriesController($container))->add(new OnlyAdminMiddleware())
    ->add($authMiddleware);
$app->get('/categories/{id}', new FindCategoriesController($container))->add(new OnlyAdminMiddleware())
    ->add($authMiddleware);
$app->delete('/categories/{id}', new DeleteCategoriesController($container))
    ->add(new OnlyAdminMiddleware())->add($authMiddleware);
$app->put('/categories/{id}', new UpdateCategoriesController($container))
    ->add(new OnlyAdminMiddleware())->add($authMiddleware);


$customErrorHandler = new CustomErrorHandler($app);

$displayErrorDetails = $_ENV['APP_ENV'] !== 'prod';

$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->run();
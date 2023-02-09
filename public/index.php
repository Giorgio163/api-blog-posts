<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Project4\Controller\CreateCategoriesController;
use Project4\Controller\CreatePostsCategoriesController;
use Project4\Controller\CreatePostsController;
use Project4\Controller\DeleteCategoriesController;
use Project4\Controller\DeletePostController;
use Project4\Controller\FindCategoriesController;
use Project4\Controller\FindPostController;
use Project4\Controller\FindPostsCategoriesController;
use Project4\Controller\HomeController;
use Project4\Controller\ListAllPostsSlugController;
use Project4\Controller\ListCategoriesController;
use Project4\Controller\ListPostsController;
use Project4\Controller\OpenApiController;
use Project4\Controller\UpdateCategoriesController;
use Project4\Controller\UpdatePostController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../boot.php';

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

// API
$app->get('/apidocs', fn () => new HtmlResponse(file_get_contents(__DIR__ . '/apidocs.html')));
$app->get('/openApi', OpenApiController::class);

// Homepage
$app->get('/', HomeController::class);

// Routes Posts
$app->get('/posts/listAll', new ListPostsController($container));
$app->get('/posts/listAllBySlug/{slug}', new ListAllPostsSlugController($container));
$app->post('/posts/create', new CreatePostsController($container));
$app->get('/posts/{id}', new FindPostController($container));
$app->delete('/post/delete/{id}',new DeletePostController($container));
$app->put('/post/update/{id}',new UpdatePostController($container));

// Routes Categories
$app->get('/categories/listAllCategories', new ListCategoriesController($container));
$app->post('/categories/create', new CreateCategoriesController($container));
$app->get('/categories/{id}', new FindCategoriesController($container));
$app->delete('/categories/delete/{id}', new DeleteCategoriesController($container));
$app->put('/categories/update/{id}', new UpdateCategoriesController($container));

// Routes PostsCategory
$app->post('/PostsCategories/create', new CreatePostsCategoriesController($container));
$app->get('/PostsCategories/{id_post}', new FindPostsCategoriesController($container));

$app->addErrorMiddleware(true, true, true);

$app->run();
<?php

use DI\Container;
use Project4\Repository\PostsRepositoryFromPdo;

$container = new Container();

$container->set('settings', static function() {
    return [
        'db' => [
            'host' => 'localhost',
            'dbname' => 'api',
            'user' => 'root',
            'pass' => '',
        ]
    ];
});

$container->set('db', function ($c) {
    $db = $c->get('settings')['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
});

$container->set('posts-repository', static function (Container $c) {
   $pdo = $c->get('db');
   return new PostsRepositoryFromPdo($pdo);
});


return $container;
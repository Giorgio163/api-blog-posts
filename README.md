# API Project Module 4

An API application that lets the user create posts, categories, and the relation between posts categories. The Application uses the full OOP paradigms. The Application is having routes to create, read, update, and delete posts and Categories

## Getting started
## Instructions for installation

- Clone repository: `https://gitlab.com/TiPhOoN/php4.api.project.git`
- Create the DB: `php cli/create-db.php`
- Install the composer dependencies: `composer install`
- Configure the environment: `cp .env.example .env`
- Add your configuration to the `.env` file
- Run the application in your preferred localhost: `php -S localhost:???? -t public/`
- Run a test using PHPStan to see the code quality: `vendor/bin/phpstan analyse src`
- Run a test using PHP Code Sniffer: `./vendor/bin/phpcs --standard=PSR12 src/`
- php vendor/bin/phpunit test/ --colors


## Required

- Slim Framework: `composer require slim/slim:"4.*"`,
-  `composer require slim/psr7`,
-  `composer require nyholm/psr7 nyholm/psr7-server`,
-  `composer require guzzlehttp/psr7 "^2"`,
-  `composer require laminas/laminas-diactoros`,
-  `composer require php-di/slim-bridge`
- Ramsey Uuid: `composer require ramsey/uuid`
- Dotenv: `composer require vlucas/phpdotenv`
- Swagger: `composer require zircote/swagger-php`
- Slugify: `composer require cocur/slugify`
- `composer require --dev phpunit/phpunit ^9.5`
- composer require monolog/monolog


### Remember to install PHPSTAN and codesniffer during the installation process in dev, if unable run the following:

- PHP Stan: `composer require --dev phpstan/phpstan`
- PHP Code Sniffer: `composer require squizlabs/php_codesniffer`

# To run the application;

- `http://localhost:????/apidocs`

#### Use the following link for the images 

- `https://www.base64encoder.io/image-to-base64-converter/`
<p align="center">
  <img align="center" height="200" src="public/elephant.png">
</p>


# API Project 

An API application that lets the user create posts, categories, and the relation between posts categories. The Application uses the full OOP paradigms. The Application is having routes to create, read, update, and delete posts and Categories

## Instructions for installation:

- Clone repository: `https://github.com/Giorgio163/api-php.git`
- Create DB: `api`
- Create the DB: `php vendor/bin/doctrine orm:schema-tool:create`
- Install the composer dependencies: `composer install`
- Configure the environment: `cp .env.example .env`
- Add your configuration to the `.env` file
- Run the application in your preferred localhost: `php -S localhost:???? -t public/`
- Run a test using PHPStan to see the code quality: `vendor/bin/phpstan analyse src`
- Run a test using PHP Code Sniffer: `./vendor/bin/phpcs --standard=PSR12 src/`
- php vendor/bin/phpunit test/ --colors


## The design patterns used in this project are:

- Fluent Interface:

  A fluent interface is normally implemented by using method chaining to implement method cascading (in languages that do not natively support cascading), concretely by having each method return the object to which it is attached, often referred to as this or self. Stated more abstractly, a fluent interface relays the instruction context of a subsequent call in method chaining, where generally the context is
Defined through the return value of a called method
Self-referential, where the new context is equivalent to the last context
Terminated through the return of a void context.


- Dependency Injection:

  In software engineering, dependency injection is a design pattern in which an object or function receives other objects or functions that it depends on. A form of inversion of control, dependency injection aims to separate the concerns of constructing objects and using them, leading to loosely coupled programs. The pattern ensures that an object or function which wants to use a given service should not have to know how to construct those services. Instead, the receiving 'client' (object or function) is provided with its dependencies by external code (an 'injector'), which it is not aware of. Fundamentally, dependency injection consists of passing parameters to a method.


- Model-View-Controller (MVC):

  MVC, which stands for Model-View-Controller, is a design pattern commonly used in software engineering. It is used to separate the concerns of an application into three interconnected components: the model, the view, and the controller.
The Model represents the data and business logic of the application. It is responsible for managing the data, processing requests, and providing information to the View.
The View is responsible for rendering the data to the user. It receives input from the user, and sends it to the Controller for processing.
The Controller acts as an intermediary between the Model and the View. It receives input from the View, processes it, and sends commands to the Model to update the data or perform actions. It then sends the updated data to the View for rendering.
The MVC pattern allows for modular development, where each component can be developed and tested independently. It also promotes separation of concerns, making it easier to maintain and update the application.


- Repository:

  The Repository pattern is a design pattern commonly used in software engineering that provides a way to manage data storage and retrieval in a clean and modular way.
The basic idea behind the Repository pattern is to create an interface that abstracts away the details of data storage, and provides a standardized way for other parts of the application to interact with that data. This interface is implemented by a concrete repository class, which handles the actual storage and retrieval of data from the underlying data store, such as a database or file system.
Using the Repository pattern can help to decouple the application logic from the details of the data storage mechanism, making it easier to change the underlying storage implementation without affecting other parts of the application. It also promotes code reuse, as the repository can be used by multiple parts of the application to access the same data in a consistent way.
Overall, the Repository pattern is a powerful tool for managing data storage and retrieval in a clean and modular way, and is widely used in software engineering today.

## Getting started
App Routes

### JWT:

- [POST] /jwt

### Home:

- [GET] /

### OpenApi:

- [GET] /apidocs

### Posts:

- [POST] /posts/create
- [GET] /posts/all
- [GET] /posts/{id}
- [GET] /posts/bySlug/{slug}
- [PUT] /post/{id}
- [DELETE] /post/{id}

### Categories:

- [POST] /categories/create
- [GET] /categories/all
- [GET] /categories/{id}
- [PUT] /categories/{id}
- [DELETE] /categories/{id}

#### Use the following link for the images:

- `https://www.base64encoder.io/image-to-base64-converter/`
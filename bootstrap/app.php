<?php

use Laravel\Lumen\Routing\Router;
use Sakila\Providers\CommandBusProvider;
use Sakila\Transformer\FractalTransformerAdapter;
use Sakila\Transformer\Transformer;

require_once __DIR__.'/../vendor/autoload.php';

try {
    $file = isset($_GET['testing']) || getenv('APP_ENV') === 'testing' ? '.env_testing' : '.env';
    (new Dotenv\Dotenv(__DIR__.'/../', $file))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Sakila\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Sakila\Console\Kernel::class
);

$app->singleton(Transformer::class, FractalTransformerAdapter::class);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    Sakila\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => Sakila\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

 $app->register(Sakila\Providers\SakilaServiceProvider::class);
 $app->register(CommandBusProvider::class);

// $app->register(Sakila\Providers\AuthServiceProvider::class);
// $app->register(Sakila\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'Sakila\Http\Controllers',
], function (Router $router) {
    require __DIR__ . '/../routes/api.php';
});

return $app;

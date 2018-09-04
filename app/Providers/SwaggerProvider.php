<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Router;

class SwaggerProvider extends ServiceProvider
{
    public function boot(Router $router): void
    {
        $router->get('/docs', function () {
            return view('swagger.ui', ['openApi' => 'docs/openapi.json']);
        });

        $router->get('/docs/openapi.json', function (Application $app) {
            $openapi = file_get_contents($app->basePath('resources/docs/openapi.json'));

            return response()->json(json_decode($openapi, true));
        });
    }

    public function register(): void
    {
    }
}

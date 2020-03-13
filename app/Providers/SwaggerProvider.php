<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Router;
use Sakila\Exceptions\UnexpectedValueException;

class SwaggerProvider extends ServiceProvider
{
    public function boot(Router $router): void
    {
        $router->get('/docs', function () {
            return view('swagger.ui', ['openApi' => 'docs/openapi.json']);
        });

        $router->get('/docs/openapi.json', function (Application $app) {
            $openApi = file_get_contents($app->basePath('resources/docs/openapi.json'));
            $response = response();
            if (!$response instanceof ResponseFactory) {
                throw new UnexpectedValueException();
            }

            return $response->json(json_decode((string)$openApi, true));
        });
    }

    public function register(): void
    {
        return;
    }
}

<?php

namespace Sakila\Http\Middleware;

use Closure;
use League\Fractal\Manager;

class FractalMiddleware
{
    /**
     * @var \League\Fractal\Manager
     */
    private $manager;

    /**
     * @param \League\Fractal\Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('include')) {
            $this->manager->parseIncludes($request->input('include'));
        }

        return $next($request);
    }
}

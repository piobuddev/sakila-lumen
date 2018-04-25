<?php

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use Sakila\Domain\Actor\Repository\Database\ActorRepository;
use Sakila\Domain\Category\Repository\Database\CategoryRepository;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Illuminate\Connection;
use Sakila\Repository\Database\Table\NameResolver;
use Sakila\Repository\Database\Table\SimpleNameResolver;
use Sakila\Validators\ActorValidator;
use Sakila\Validators\CategoryValidator;

class SakilaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NameResolver::class, SimpleNameResolver::class);
        $this->registerDatabaseConnection();
        $this->registerRepositories();
        $this->registerValidators();
    }

    /**
     * @return void
     */
    private function registerRepositories(): void
    {
        $this->app->bind(\Sakila\Domain\Actor\Repository\ActorRepository::class, ActorRepository::class);
        $this->app->bind(\Sakila\Domain\Category\Repository\CategoryRepository::class, CategoryRepository::class);
    }

    /**
     * @return void
     */
    private function registerDatabaseConnection(): void
    {
        $this->app->singleton(ConnectionInterface::class, Connection::class);
    }

    /**
     * @return void
     */
    private function registerValidators(): void
    {
        $this->app->bind(\Sakila\Domain\Actor\Validator\ActorValidator::class, ActorValidator::class);
        $this->app->bind(\Sakila\Domain\Category\Validator\CategoryValidator::class, CategoryValidator::class);
    }
}

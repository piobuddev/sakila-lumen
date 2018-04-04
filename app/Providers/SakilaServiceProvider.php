<?php

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Illuminate\Connection;
use Sakila\Validators\ActorValidator;

class SakilaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDatabaseConnection();
        $this->registerRepositories();
        $this->registerValidators();
    }

    /**
     * @return void
     */
    private function registerRepositories(): void
    {
        $this->app->bind(ActorRepositoryInterface::class, ActorRepository::class);
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
    private function registerValidators()
    {
        $this->app->bind(\Sakila\Domain\Actor\Validator\ActorValidator::class, ActorValidator::class);
    }
}

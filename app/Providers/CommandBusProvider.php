<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use Sakila\Command\Bus\CommandBus;
use Sakila\Command\IlluminateCommandBusAdapter;
use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Domain\Actor\Commands\Handlers\ActorHandler;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Domain\Category\Commands\AddCategoryCommand;
use Sakila\Domain\Category\Commands\Handlers\CategoryHandler;
use Sakila\Domain\Category\Commands\UpdateCategoryCommand;
use Sakila\Domain\Country\Commands\AddCountryCommand;
use Sakila\Domain\Country\Commands\Handlers\CountryHandler;
use Sakila\Domain\Country\Commands\UpdateCountryCommand;

class CommandBusProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $commandHandlersMap = [
        AddActorCommand::class       => ActorHandler::class,
        UpdateActorCommand::class    => ActorHandler::class,
        AddCategoryCommand::class    => CategoryHandler::class,
        UpdateCategoryCommand::class => CategoryHandler::class,
        AddCountryCommand::class     => CountryHandler::class,
        UpdateCountryCommand::class  => CountryHandler::class,
    ];

    public function boot(): void
    {
        $this->app->make(CommandBus::class)->map($this->commandHandlersMap);
    }

    public function register(): void
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBusAdapter::class);
    }
}

<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use Sakila\Command\Bus\CommandBus;
use Sakila\Command\IlluminateCommandBusAdapter;
use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Domain\Actor\Commands\Handlers\ActorHandler;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Domain\Address\Commands\AddAddressCommand;
use Sakila\Domain\Address\Commands\Handlers\AddressHandler;
use Sakila\Domain\Address\Commands\UpdateAddressCommand;
use Sakila\Domain\Category\Commands\AddCategoryCommand;
use Sakila\Domain\Category\Commands\Handlers\CategoryHandler;
use Sakila\Domain\Category\Commands\UpdateCategoryCommand;
use Sakila\Domain\City\Commands\AddCityCommand;
use Sakila\Domain\City\Commands\Handlers\CityHandler;
use Sakila\Domain\City\Commands\UpdateCityCommand;
use Sakila\Domain\Country\Commands\AddCountryCommand;
use Sakila\Domain\Country\Commands\Handlers\CountryHandler;
use Sakila\Domain\Country\Commands\UpdateCountryCommand;
use Sakila\Domain\Language\Commands\AddLanguageCommand;
use Sakila\Domain\Language\Commands\Handlers\LanguageHandler;
use Sakila\Domain\Language\Commands\UpdateLanguageCommand;

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
        AddLanguageCommand::class    => LanguageHandler::class,
        UpdateLanguageCommand::class => LanguageHandler::class,
        AddCityCommand::class        => CityHandler::class,
        UpdateCityCommand::class     => CityHandler::class,
        AddAddressCommand::class     => AddressHandler::class,
        UpdateAddressCommand::class  => AddressHandler::class,
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

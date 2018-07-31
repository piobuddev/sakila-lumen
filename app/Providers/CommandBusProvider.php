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
use Sakila\Domain\Customer\Commands\AddCustomerCommand;
use Sakila\Domain\Customer\Commands\Handlers\CustomerHandler;
use Sakila\Domain\Customer\Commands\UpdateCustomerCommand;
use Sakila\Domain\Film\Commands\AddFilmCommand;
use Sakila\Domain\Film\Commands\Handlers\FilmHandler;
use Sakila\Domain\Film\Commands\UpdateFilmCommand;
use Sakila\Domain\Inventory\Commands\AddInventoryCommand;
use Sakila\Domain\Inventory\Commands\Handlers\InventoryHandler;
use Sakila\Domain\Inventory\Commands\UpdateInventoryCommand;
use Sakila\Domain\Language\Commands\AddLanguageCommand;
use Sakila\Domain\Language\Commands\Handlers\LanguageHandler;
use Sakila\Domain\Language\Commands\UpdateLanguageCommand;
use Sakila\Domain\Payment\Commands\AddPaymentCommand;
use Sakila\Domain\Payment\Commands\Handlers\PaymentHandler;
use Sakila\Domain\Payment\Commands\UpdatePaymentCommand;
use Sakila\Domain\Rental\Commands\AddRentalCommand;
use Sakila\Domain\Rental\Commands\Handlers\RentalHandler;
use Sakila\Domain\Rental\Commands\UpdateRentalCommand;
use Sakila\Domain\Staff\Commands\AddStaffCommand;
use Sakila\Domain\Staff\Commands\Handlers\StaffHandler;
use Sakila\Domain\Staff\Commands\UpdateStaffCommand;
use Sakila\Domain\Store\Commands\AddStoreCommand;
use Sakila\Domain\Store\Commands\Handlers\StoreHandler;
use Sakila\Domain\Store\Commands\UpdateStoreCommand;

class CommandBusProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $commandHandlersMap = [
        AddActorCommand::class        => ActorHandler::class,
        UpdateActorCommand::class     => ActorHandler::class,
        AddCategoryCommand::class     => CategoryHandler::class,
        UpdateCategoryCommand::class  => CategoryHandler::class,
        AddCountryCommand::class      => CountryHandler::class,
        UpdateCountryCommand::class   => CountryHandler::class,
        AddLanguageCommand::class     => LanguageHandler::class,
        UpdateLanguageCommand::class  => LanguageHandler::class,
        AddCityCommand::class         => CityHandler::class,
        UpdateCityCommand::class      => CityHandler::class,
        AddAddressCommand::class      => AddressHandler::class,
        UpdateAddressCommand::class   => AddressHandler::class,
        AddStoreCommand::class        => StoreHandler::class,
        UpdateStoreCommand::class     => StoreHandler::class,
        AddStaffCommand::class        => StaffHandler::class,
        UpdateStaffCommand::class     => StaffHandler::class,
        AddCustomerCommand::class     => CustomerHandler::class,
        UpdateCustomerCommand::class  => CustomerHandler::class,
        AddFilmCommand::class         => FilmHandler::class,
        UpdateFilmCommand::class      => FilmHandler::class,
        AddInventoryCommand::class    => InventoryHandler::class,
        UpdateInventoryCommand::class => InventoryHandler::class,
        AddRentalCommand::class       => RentalHandler::class,
        UpdateRentalCommand::class    => RentalHandler::class,
        AddPaymentCommand::class      => PaymentHandler::class,
        UpdatePaymentCommand::class   => PaymentHandler::class,
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

<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\Database\ActorRepository;
use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\Database\AddressRepository;
use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\Database\CategoryRepository;
use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\Database\CityRepository;
use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\Database\CountryRepository;
use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\Database\CustomerRepository;
use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\Database\FilmRepository;
use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\Database\InventoryRepository;
use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\Database\LanguageRepository;
use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\Database\PaymentRepository;
use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\Database\RentalRepository;
use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\Database\StaffRepository;
use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\Database\StoreRepository;
use Sakila\Entity\FactoryInterface;
use Sakila\Entity\IlluminateFactoryAdapter;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Illuminate\Connection;
use Sakila\Repository\Database\Table\NameResolver;
use Sakila\Repository\Database\Table\SimpleNameResolver;
use Sakila\Transformer\ActorTransformer;
use Sakila\Transformer\AddressTransformer;
use Sakila\Transformer\CategoryTransformer;
use Sakila\Transformer\CityTransformer;
use Sakila\Transformer\CountryTransformer;
use Sakila\Transformer\CustomerTransformer;
use Sakila\Transformer\FilmTransformer;
use Sakila\Transformer\InventoryTransformer;
use Sakila\Transformer\LanguageTransformer;
use Sakila\Transformer\PaymentTransformer;
use Sakila\Transformer\RentalTransformer;
use Sakila\Transformer\StaffTransformer;
use Sakila\Transformer\StoreTransformer;
use Sakila\Validators\ActorValidator;
use Sakila\Validators\AddressValidator;
use Sakila\Validators\CategoryValidator;
use Sakila\Validators\CityValidator;
use Sakila\Validators\CountryValidator;
use Sakila\Validators\CustomerValidator;
use Sakila\Validators\FilmValidator;
use Sakila\Validators\InventoryValidator;
use Sakila\Validators\LanguageValidator;
use Sakila\Validators\PaymentValidator;
use Sakila\Validators\RentalValidator;
use Sakila\Validators\StaffValidator;
use Sakila\Validators\StoreValidator;

class SakilaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(NameResolver::class, SimpleNameResolver::class);
        $this->app->bind(FactoryInterface::class, IlluminateFactoryAdapter::class);
        $this->app->singleton(Manager::class, function () {
            return new Manager();
        });

        $this->registerDatabaseConnection();
        $this->registerRepositories();
        $this->registerTransformers();
        $this->registerValidators();
    }

    /**
     * @return void
     */
    private function registerRepositories(): void
    {
        $this->app->bind(\Sakila\Domain\Actor\Repository\ActorRepository::class, ActorRepository::class);
        $this->app->bind(\Sakila\Domain\Category\Repository\CategoryRepository::class, CategoryRepository::class);
        $this->app->bind(\Sakila\Domain\Country\Repository\CountryRepository::class, CountryRepository::class);
        $this->app->bind(\Sakila\Domain\Language\Repository\LanguageRepository::class, LanguageRepository::class);
        $this->app->bind(\Sakila\Domain\City\Repository\CityRepository::class, CityRepository::class);
        $this->app->bind(\Sakila\Domain\Address\Repository\AddressRepository::class, AddressRepository::class);
        $this->app->bind(\Sakila\Domain\Store\Repository\StoreRepository::class, StoreRepository::class);
        $this->app->bind(\Sakila\Domain\Staff\Repository\StaffRepository::class, StaffRepository::class);
        $this->app->bind(\Sakila\Domain\Customer\Repository\CustomerRepository::class, CustomerRepository::class);
        $this->app->bind(\Sakila\Domain\Film\Repository\FilmRepository::class, FilmRepository::class);
        $this->app->bind(\Sakila\Domain\Inventory\Repository\InventoryRepository::class, InventoryRepository::class);
        $this->app->bind(\Sakila\Domain\Rental\Repository\RentalRepository::class, RentalRepository::class);
        $this->app->bind(\Sakila\Domain\Payment\Repository\PaymentRepository::class, PaymentRepository::class);
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
        $this->app->bind(\Sakila\Domain\Country\Validator\CountryValidator::class, CountryValidator::class);
        $this->app->bind(\Sakila\Domain\Language\Validator\LanguageValidator::class, LanguageValidator::class);
        $this->app->bind(\Sakila\Domain\City\Validator\CityValidator::class, CityValidator::class);
        $this->app->bind(\Sakila\Domain\Address\Validator\AddressValidator::class, AddressValidator::class);
        $this->app->bind(\Sakila\Domain\Store\Validator\StoreValidator::class, StoreValidator::class);
        $this->app->bind(\Sakila\Domain\Staff\Validator\StaffValidator::class, StaffValidator::class);
        $this->app->bind(\Sakila\Domain\Customer\Validator\CustomerValidator::class, CustomerValidator::class);
        $this->app->bind(\Sakila\Domain\Film\Validator\FilmValidator::class, FilmValidator::class);
        $this->app->bind(\Sakila\Domain\Inventory\Validator\InventoryValidator::class, InventoryValidator::class);
        $this->app->bind(\Sakila\Domain\Rental\Validator\RentalValidator::class, RentalValidator::class);
        $this->app->bind(\Sakila\Domain\Payment\Validator\PaymentValidator::class, PaymentValidator::class);
    }

    private function registerTransformers(): void
    {
        $this->app->bind(ActorTransformerInterface::class, ActorTransformer::class);
        $this->app->bind(AddressTransformerInterface::class, AddressTransformer::class);
        $this->app->bind(CategoryTransformerInterface::class, CategoryTransformer::class);
        $this->app->bind(CityTransformerInterface::class, CityTransformer::class);
        $this->app->bind(CountryTransformerInterface::class, CountryTransformer::class);
        $this->app->bind(CustomerTransformerInterface::class, CustomerTransformer::class);
        $this->app->bind(FilmTransformerInterface::class, FilmTransformer::class);
        $this->app->bind(InventoryTransformerInterface::class, InventoryTransformer::class);
        $this->app->bind(LanguageTransformerInterface::class, LanguageTransformer::class);
        $this->app->bind(PaymentTransformerInterface::class, PaymentTransformer::class);
        $this->app->bind(RentalTransformerInterface::class, RentalTransformer::class);
        $this->app->bind(StaffTransformerInterface::class, StaffTransformer::class);
        $this->app->bind(StoreTransformerInterface::class, StoreTransformer::class);
    }
}

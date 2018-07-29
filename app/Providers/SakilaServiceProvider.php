<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use Sakila\Domain\Actor\Repository\Database\ActorRepository;
use Sakila\Domain\Address\Repository\Database\AddressRepository;
use Sakila\Domain\Category\Repository\Database\CategoryRepository;
use Sakila\Domain\City\Repository\Database\CityRepository;
use Sakila\Domain\Country\Repository\Database\CountryRepository;
use Sakila\Domain\Customer\Repository\Database\CustomerRepository;
use Sakila\Domain\Film\Repository\Database\FilmRepository;
use Sakila\Domain\Language\Repository\Database\LanguageRepository;
use Sakila\Domain\Staff\Repository\Database\StaffRepository;
use Sakila\Domain\Store\Repository\Database\StoreRepository;
use Sakila\Entity\FactoryInterface;
use Sakila\Entity\IlluminateFactoryAdapter;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Illuminate\Connection;
use Sakila\Repository\Database\Table\NameResolver;
use Sakila\Repository\Database\Table\SimpleNameResolver;
use Sakila\Validators\ActorValidator;
use Sakila\Validators\AddressValidator;
use Sakila\Validators\CategoryValidator;
use Sakila\Validators\CityValidator;
use Sakila\Validators\CountryValidator;
use Sakila\Validators\CustomerValidator;
use Sakila\Validators\FilmValidator;
use Sakila\Validators\LanguageValidator;
use Sakila\Validators\StaffValidator;
use Sakila\Validators\StoreValidator;

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
        $this->app->bind(FactoryInterface::class, IlluminateFactoryAdapter::class);
        $this->app->singleton(Manager::class, function () {
            return new Manager();
        });

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
        $this->app->bind(\Sakila\Domain\Country\Repository\CountryRepository::class, CountryRepository::class);
        $this->app->bind(\Sakila\Domain\Language\Repository\LanguageRepository::class, LanguageRepository::class);
        $this->app->bind(\Sakila\Domain\City\Repository\CityRepository::class, CityRepository::class);
        $this->app->bind(\Sakila\Domain\Address\Repository\AddressRepository::class, AddressRepository::class);
        $this->app->bind(\Sakila\Domain\Store\Repository\StoreRepository::class, StoreRepository::class);
        $this->app->bind(\Sakila\Domain\Staff\Repository\StaffRepository::class, StaffRepository::class);
        $this->app->bind(\Sakila\Domain\Customer\Repository\CustomerRepository::class, CustomerRepository::class);
        $this->app->bind(\Sakila\Domain\Film\Repository\FilmRepository::class, FilmRepository::class);
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
    }
}

<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Domain\Actor\Repository\Database\ActorRepository;
use Sakila\Domain\Actor\Validator\ActorValidatorInterface;
use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepositoryInterface;
use Sakila\Domain\Address\Repository\Database\AddressRepository;
use Sakila\Domain\Address\Validator\AddressValidatorInterface;
use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepositoryInterface;
use Sakila\Domain\Category\Repository\Database\CategoryRepository;
use Sakila\Domain\Category\Validator\CategoryValidatorInterface;
use Sakila\Domain\City\Entity\Transformer\CityTransformerInterface;
use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Domain\City\Repository\Database\CityRepository;
use Sakila\Domain\City\Validator\CityValidatorInterface;
use Sakila\Domain\Country\Entity\Transformer\CountryTransformerInterface;
use Sakila\Domain\Country\Repository\CountryRepositoryInterface;
use Sakila\Domain\Country\Repository\Database\CountryRepository;
use Sakila\Domain\Country\Validator\CountryValidatorInterface;
use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepositoryInterface;
use Sakila\Domain\Customer\Repository\Database\CustomerRepository;
use Sakila\Domain\Customer\Validator\CustomerValidatorInterface;
use Sakila\Domain\Film\Entity\Transformer\FilmTransformerInterface;
use Sakila\Domain\Film\Repository\Database\FilmRepository;
use Sakila\Domain\Film\Repository\FilmRepositoryInterface;
use Sakila\Domain\Film\Validator\FilmValidatorInterface;
use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\Database\InventoryRepository;
use Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Sakila\Domain\Inventory\Validator\InventoryValidatorInterface;
use Sakila\Domain\Language\Entity\Transformer\LanguageTransformerInterface;
use Sakila\Domain\Language\Repository\Database\LanguageRepository;
use Sakila\Domain\Language\Repository\LanguageRepositoryInterface;
use Sakila\Domain\Language\Validator\LanguageValidatorInterface;
use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\Database\PaymentRepository;
use Sakila\Domain\Payment\Repository\PaymentRepositoryInterface;
use Sakila\Domain\Payment\Validator\PaymentValidatorInterface;
use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\Database\RentalRepository;
use Sakila\Domain\Rental\Repository\RentalRepositoryInterface;
use Sakila\Domain\Rental\Validator\RentalValidatorInterface;
use Sakila\Domain\Staff\Entity\Transformer\StaffTransformerInterface;
use Sakila\Domain\Staff\Repository\Database\StaffRepository;
use Sakila\Domain\Staff\Repository\StaffRepositoryInterface;
use Sakila\Domain\Staff\Validator\StaffValidatorInterface;
use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\Database\StoreRepository;
use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Domain\Store\Validator\StoreValidatorInterface;
use Sakila\Entity\FactoryInterface;
use Sakila\Entity\IlluminateFactoryAdapter;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Illuminate\Connection;
use Sakila\Repository\Database\Table\NameResolverInterface;
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
        $this->app->bind(NameResolverInterface::class, SimpleNameResolver::class);
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
        $this->app->bind(ActorRepositoryInterface::class, ActorRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(FilmRepositoryInterface::class, FilmRepository::class);
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);
        $this->app->bind(RentalRepositoryInterface::class, RentalRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
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
        $this->app->bind(ActorValidatorInterface::class, ActorValidator::class);
        $this->app->bind(CategoryValidatorInterface::class, CategoryValidator::class);
        $this->app->bind(CountryValidatorInterface::class, CountryValidator::class);
        $this->app->bind(LanguageValidatorInterface::class, LanguageValidator::class);
        $this->app->bind(CityValidatorInterface::class, CityValidator::class);
        $this->app->bind(AddressValidatorInterface::class, AddressValidator::class);
        $this->app->bind(StoreValidatorInterface::class, StoreValidator::class);
        $this->app->bind(StaffValidatorInterface::class, StaffValidator::class);
        $this->app->bind(CustomerValidatorInterface::class, CustomerValidator::class);
        $this->app->bind(FilmValidatorInterface::class, FilmValidator::class);
        $this->app->bind(InventoryValidatorInterface::class, InventoryValidator::class);
        $this->app->bind(RentalValidatorInterface::class, RentalValidator::class);
        $this->app->bind(PaymentValidatorInterface::class, PaymentValidator::class);
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

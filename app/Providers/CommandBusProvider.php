<?php declare(strict_types=1);

namespace Sakila\Providers;

use Illuminate\Support\ServiceProvider;
use Sakila\Command\Bus\CommandBus;
use Sakila\Command\IlluminateCommandBusAdapter;
use Sakila\Domain\Actor\Service\AddActorService;
use Sakila\Domain\Actor\Service\RemoveActorService;
use Sakila\Domain\Actor\Service\Request\AddActorRequest;
use Sakila\Domain\Actor\Service\Request\RemoveActorRequest;
use Sakila\Domain\Actor\Service\Request\ShowActorRequest;
use Sakila\Domain\Actor\Service\Request\ShowActorsRequest;
use Sakila\Domain\Actor\Service\Request\UpdateActorRequest;
use Sakila\Domain\Actor\Service\ShowActorService;
use Sakila\Domain\Actor\Service\ShowActorsService;
use Sakila\Domain\Actor\Service\UpdateActorService;
use Sakila\Domain\Address\Service\AddAddressService;
use Sakila\Domain\Address\Service\RemoveAddressService;
use Sakila\Domain\Address\Service\Request\AddAddressRequest;
use Sakila\Domain\Address\Service\Request\RemoveAddressRequest;
use Sakila\Domain\Address\Service\Request\ShowAddressesRequest;
use Sakila\Domain\Address\Service\Request\ShowAddressRequest;
use Sakila\Domain\Address\Service\Request\UpdateAddressRequest;
use Sakila\Domain\Address\Service\ShowAddressesService;
use Sakila\Domain\Address\Service\ShowAddressService;
use Sakila\Domain\Address\Service\UpdateAddressService;
use Sakila\Domain\Category\Service\AddCategoryService;
use Sakila\Domain\Category\Service\RemoveCategoryService;
use Sakila\Domain\Category\Service\Request\AddCategoryRequest;
use Sakila\Domain\Category\Service\Request\RemoveCategoryRequest;
use Sakila\Domain\Category\Service\Request\ShowCategoriesRequest;
use Sakila\Domain\Category\Service\Request\ShowCategoryRequest;
use Sakila\Domain\Category\Service\Request\UpdateCategoryRequest;
use Sakila\Domain\Category\Service\ShowCategoriesService;
use Sakila\Domain\Category\Service\ShowCategoryService;
use Sakila\Domain\Category\Service\UpdateCategoryService;
use Sakila\Domain\City\Service\AddCityService;
use Sakila\Domain\City\Service\RemoveCityService;
use Sakila\Domain\City\Service\Request\AddCityRequest;
use Sakila\Domain\City\Service\Request\RemoveCityRequest;
use Sakila\Domain\City\Service\Request\ShowCitiesRequest;
use Sakila\Domain\City\Service\Request\ShowCityRequest;
use Sakila\Domain\City\Service\Request\UpdateCityRequest;
use Sakila\Domain\City\Service\ShowCitiesService;
use Sakila\Domain\City\Service\ShowCityService;
use Sakila\Domain\City\Service\UpdateCityService;
use Sakila\Domain\Country\Service\AddCountryService;
use Sakila\Domain\Country\Service\RemoveCountryService;
use Sakila\Domain\Country\Service\Request\AddCountryRequest;
use Sakila\Domain\Country\Service\Request\RemoveCountryRequest;
use Sakila\Domain\Country\Service\Request\ShowCountriesRequest;
use Sakila\Domain\Country\Service\Request\ShowCountryRequest;
use Sakila\Domain\Country\Service\Request\UpdateCountryRequest;
use Sakila\Domain\Country\Service\ShowCountriesService;
use Sakila\Domain\Country\Service\ShowCountryService;
use Sakila\Domain\Country\Service\UpdateCountryService;
use Sakila\Domain\Customer\Service\AddCustomerService;
use Sakila\Domain\Customer\Service\RemoveCustomerService;
use Sakila\Domain\Customer\Service\Request\AddCustomerRequest;
use Sakila\Domain\Customer\Service\Request\RemoveCustomerRequest;
use Sakila\Domain\Customer\Service\Request\ShowCustomerRequest;
use Sakila\Domain\Customer\Service\Request\ShowCustomersRequest;
use Sakila\Domain\Customer\Service\Request\UpdateCustomerRequest;
use Sakila\Domain\Customer\Service\ShowCustomerService;
use Sakila\Domain\Customer\Service\ShowCustomersService;
use Sakila\Domain\Customer\Service\UpdateCustomerService;
use Sakila\Domain\Film\Service\AddFilmService;
use Sakila\Domain\Film\Service\RemoveFilmService;
use Sakila\Domain\Film\Service\Request\AddFilmRequest;
use Sakila\Domain\Film\Service\Request\RemoveFilmRequest;
use Sakila\Domain\Film\Service\Request\ShowFilmRequest;
use Sakila\Domain\Film\Service\Request\ShowFilmsRequest;
use Sakila\Domain\Film\Service\Request\UpdateFilmRequest;
use Sakila\Domain\Film\Service\ShowFilmService;
use Sakila\Domain\Film\Service\ShowFilmsService;
use Sakila\Domain\Film\Service\UpdateFilmService;
use Sakila\Domain\Inventory\Service\AddInventoryService;
use Sakila\Domain\Inventory\Service\RemoveInventoryService;
use Sakila\Domain\Inventory\Service\Request\AddInventoryRequest;
use Sakila\Domain\Inventory\Service\Request\RemoveInventoryRequest;
use Sakila\Domain\Inventory\Service\Request\ShowInventoriesRequest;
use Sakila\Domain\Inventory\Service\Request\ShowInventoryRequest;
use Sakila\Domain\Inventory\Service\Request\UpdateInventoryRequest;
use Sakila\Domain\Inventory\Service\ShowInventoriesService;
use Sakila\Domain\Inventory\Service\ShowInventoryService;
use Sakila\Domain\Inventory\Service\UpdateInventoryService;
use Sakila\Domain\Language\Service\AddLanguageService;
use Sakila\Domain\Language\Service\RemoveLanguageService;
use Sakila\Domain\Language\Service\Request\AddLanguageRequest;
use Sakila\Domain\Language\Service\Request\RemoveLanguageRequest;
use Sakila\Domain\Language\Service\Request\ShowLanguageRequest;
use Sakila\Domain\Language\Service\Request\ShowLanguagesRequest;
use Sakila\Domain\Language\Service\Request\UpdateLanguageRequest;
use Sakila\Domain\Language\Service\ShowLanguageService;
use Sakila\Domain\Language\Service\ShowLanguagesService;
use Sakila\Domain\Language\Service\UpdateLanguageService;
use Sakila\Domain\Payment\Service\AddPaymentService;
use Sakila\Domain\Payment\Service\RemovePaymentService;
use Sakila\Domain\Payment\Service\Request\AddPaymentRequest;
use Sakila\Domain\Payment\Service\Request\RemovePaymentRequest;
use Sakila\Domain\Payment\Service\Request\ShowPaymentRequest;
use Sakila\Domain\Payment\Service\Request\ShowPaymentsRequest;
use Sakila\Domain\Payment\Service\Request\UpdatePaymentRequest;
use Sakila\Domain\Payment\Service\ShowPaymentService;
use Sakila\Domain\Payment\Service\ShowPaymentsService;
use Sakila\Domain\Payment\Service\UpdatePaymentService;
use Sakila\Domain\Rental\Service\AddRentalService;
use Sakila\Domain\Rental\Service\RemoveRentalService;
use Sakila\Domain\Rental\Service\Request\AddRentalRequest;
use Sakila\Domain\Rental\Service\Request\RemoveRentalRequest;
use Sakila\Domain\Rental\Service\Request\ShowRentalRequest;
use Sakila\Domain\Rental\Service\Request\ShowRentalsRequest;
use Sakila\Domain\Rental\Service\Request\UpdateRentalRequest;
use Sakila\Domain\Rental\Service\ShowRentalService;
use Sakila\Domain\Rental\Service\ShowRentalsService;
use Sakila\Domain\Rental\Service\UpdateRentalService;
use Sakila\Domain\Staff\Service\AddStaffService;
use Sakila\Domain\Staff\Service\RemoveStaffService;
use Sakila\Domain\Staff\Service\Request\AddStaffRequest;
use Sakila\Domain\Staff\Service\Request\RemoveStaffRequest;
use Sakila\Domain\Staff\Service\Request\ShowStaffMemberRequest;
use Sakila\Domain\Staff\Service\Request\ShowStaffRequest;
use Sakila\Domain\Staff\Service\Request\UpdateStaffRequest;
use Sakila\Domain\Staff\Service\ShowStaffMemberService;
use Sakila\Domain\Staff\Service\ShowStaffService;
use Sakila\Domain\Staff\Service\UpdateStaffService;
use Sakila\Domain\Store\Service\AddStoreService;
use Sakila\Domain\Store\Service\RemoveStoreService;
use Sakila\Domain\Store\Service\Request\AddStoreRequest;
use Sakila\Domain\Store\Service\Request\RemoveStoreRequest;
use Sakila\Domain\Store\Service\Request\ShowStoreRequest;
use Sakila\Domain\Store\Service\Request\ShowStoresRequest;
use Sakila\Domain\Store\Service\Request\UpdateStoreRequest;
use Sakila\Domain\Store\Service\ShowStoreService;
use Sakila\Domain\Store\Service\ShowStoresService;
use Sakila\Domain\Store\Service\UpdateStoreService;

class CommandBusProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $commandHandlersMap = [
        ShowActorRequest::class   => ShowActorService::class,
        ShowActorsRequest::class  => ShowActorsService::class,
        AddActorRequest::class    => AddActorService::class,
        UpdateActorRequest::class => UpdateActorService::class,
        RemoveActorRequest::class => RemoveActorService::class,

        ShowAddressRequest::class   => ShowAddressService::class,
        ShowAddressesRequest::class => ShowAddressesService::class,
        AddAddressRequest::class    => AddAddressService::class,
        UpdateAddressRequest::class => UpdateAddressService::class,
        RemoveAddressRequest::class => RemoveAddressService::class,

        ShowCategoryRequest::class   => ShowCategoryService::class,
        ShowCategoriesRequest::class => ShowCategoriesService::class,
        AddCategoryRequest::class    => AddCategoryService::class,
        UpdateCategoryRequest::class => UpdateCategoryService::class,
        RemoveCategoryRequest::class => RemoveCategoryService::class,

        ShowCityRequest::class   => ShowCityService::class,
        ShowCitiesRequest::class => ShowCitiesService::class,
        AddCityRequest::class    => AddCityService::class,
        UpdateCityRequest::class => UpdateCityService::class,
        RemoveCityRequest::class => RemoveCityService::class,

        ShowCountryRequest::class   => ShowCountryService::class,
        ShowCountriesRequest::class => ShowCountriesService::class,
        AddCountryRequest::class    => AddCountryService::class,
        UpdateCountryRequest::class => UpdateCountryService::class,
        RemoveCountryRequest::class => RemoveCountryService::class,

        ShowCustomerRequest::class   => ShowCustomerService::class,
        ShowCustomersRequest::class  => ShowCustomersService::class,
        AddCustomerRequest::class    => AddCustomerService::class,
        UpdateCustomerRequest::class => UpdateCustomerService::class,
        RemoveCustomerRequest::class => RemoveCustomerService::class,

        ShowFilmRequest::class   => ShowFilmService::class,
        ShowFilmsRequest::class  => ShowFilmsService::class,
        AddFilmRequest::class    => AddFilmService::class,
        UpdateFilmRequest::class => UpdateFilmService::class,
        RemoveFilmRequest::class => RemoveFilmService::class,

        ShowInventoryRequest::class   => ShowInventoryService::class,
        ShowInventoriesRequest::class => ShowInventoriesService::class,
        AddInventoryRequest::class    => AddInventoryService::class,
        UpdateInventoryRequest::class => UpdateInventoryService::class,
        RemoveInventoryRequest::class => RemoveInventoryService::class,

        ShowLanguageRequest::class   => ShowLanguageService::class,
        ShowLanguagesRequest::class  => ShowLanguagesService::class,
        AddLanguageRequest::class    => AddLanguageService::class,
        UpdateLanguageRequest::class => UpdateLanguageService::class,
        RemoveLanguageRequest::class => RemoveLanguageService::class,

        ShowPaymentRequest::class   => ShowPaymentService::class,
        ShowPaymentsRequest::class  => ShowPaymentsService::class,
        AddPaymentRequest::class    => AddPaymentService::class,
        UpdatePaymentRequest::class => UpdatePaymentService::class,
        RemovePaymentRequest::class => RemovePaymentService::class,

        ShowRentalRequest::class   => ShowRentalService::class,
        ShowRentalsRequest::class  => ShowRentalsService::class,
        AddRentalRequest::class    => AddRentalService::class,
        UpdateRentalRequest::class => UpdateRentalService::class,
        RemoveRentalRequest::class => RemoveRentalService::class,

        ShowStaffRequest::class       => ShowStaffService::class,
        ShowStaffMemberRequest::class => ShowStaffMemberService::class,
        AddStaffRequest::class        => AddStaffService::class,
        UpdateStaffRequest::class     => UpdateStaffService::class,
        RemoveStaffRequest::class     => RemoveStaffService::class,

        ShowStoreRequest::class   => ShowStoreService::class,
        ShowStoresRequest::class  => ShowStoresService::class,
        AddStoreRequest::class    => AddStoreService::class,
        UpdateStoreRequest::class => UpdateStoreService::class,
        RemoveStoreRequest::class => RemoveStoreService::class,

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

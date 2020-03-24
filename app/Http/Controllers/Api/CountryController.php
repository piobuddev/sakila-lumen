<?php declare(strict_types=1);


namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBusInterface;
use Sakila\Domain\Country\Service\Request\AddCountryRequest;
use Sakila\Domain\Country\Service\Request\RemoveCountryRequest;
use Sakila\Domain\Country\Service\Request\ShowCountriesRequest;
use Sakila\Domain\Country\Service\Request\ShowCountryRequest;
use Sakila\Domain\Country\Service\Request\UpdateCountryRequest;

class CountryController extends AbstractController
{
    /**
     * @var \Sakila\Command\Bus\CommandBusInterface
     */
    private $commandBus;

    /**
     * @param \Sakila\Command\Bus\CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param int $countryId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $countryId): Response
    {
        $country = $this->commandBus->execute(new ShowCountryRequest($countryId));

        return $this->response($country);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page      = (int)$request->query('page', self::DEFAULT_PAGE);
        $pageSize  = (int)$request->query('page_size', self::DEFAULT_PAGE_SIZE);
        $countries = $this->commandBus->execute(new ShowCountriesRequest($page, $pageSize));

        return $this->response($countries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $country = $this->commandBus->execute(new AddCountryRequest((array)$request->post()));

        return $this->response($country, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $countryId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $countryId, Request $request): Response
    {
        $country = $this->commandBus->execute(new UpdateCountryRequest($countryId, (array)$request->post()));

        return $this->response($country);
    }

    /**
     * @param int $countryId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $countryId): Response
    {
        $this->commandBus->execute(new RemoveCountryRequest($countryId));

        return $this->response();
    }
}

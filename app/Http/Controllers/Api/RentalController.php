<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Rental\Service\Request\AddRentalRequest;
use Sakila\Domain\Rental\Service\Request\RemoveRentalRequest;
use Sakila\Domain\Rental\Service\Request\ShowRentalRequest;
use Sakila\Domain\Rental\Service\Request\ShowRentalsRequest;
use Sakila\Domain\Rental\Service\Request\UpdateRentalRequest;

class RentalController extends AbstractController
{
    /**
     * @var \Sakila\Command\Bus\CommandBus
     */
    private $commandBus;

    /**
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param int $rentalId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $rentalId): Response
    {
        $rental = $this->commandBus->execute(new ShowRentalRequest($rentalId));

        return $this->response($rental);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page     = (int)$request->query('page', self::DEFAULT_PAGE);
        $pageSize = (int)$request->query('page_size', self::DEFAULT_PAGE_SIZE);
        $rentals  = $this->commandBus->execute(new ShowRentalsRequest($page, $pageSize));

        return $this->response($rentals);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $rental = $this->commandBus->execute(new AddRentalRequest($request->post()));

        return $this->response($rental, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $rentalId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $rentalId, Request $request): Response
    {
        $rental = $this->commandBus->execute(new UpdateRentalRequest($rentalId, $request->post()));

        return $this->response($rental);
    }

    /**
     * @param int $rentalId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $rentalId): Response
    {
        $this->commandBus->execute(new RemoveRentalRequest($rentalId));

        return $this->response();
    }
}

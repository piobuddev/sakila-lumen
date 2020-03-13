<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Address\Service\Request\AddAddressRequest;
use Sakila\Domain\Address\Service\Request\RemoveAddressRequest;
use Sakila\Domain\Address\Service\Request\ShowAddressesRequest;
use Sakila\Domain\Address\Service\Request\ShowAddressRequest;
use Sakila\Domain\Address\Service\Request\UpdateAddressRequest;

class AddressController extends AbstractController
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
     * @param int $addressId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $addressId): Response
    {
        $address = $this->commandBus->execute(new ShowAddressRequest($addressId));

        return $this->response($address);
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
        $addresses = $this->commandBus->execute(new ShowAddressesRequest($page, $pageSize));

        return $this->response($addresses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $address = $this->commandBus->execute(new AddAddressRequest((array)$request->post()));

        return $this->response($address, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $addressId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $addressId, Request $request): Response
    {
        $address = $this->commandBus->execute(new UpdateAddressRequest($addressId, (array)$request->post()));

        return $this->response($address);
    }

    /**
     * @param int $addressId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $addressId): Response
    {
        $this->commandBus->execute(new RemoveAddressRequest($addressId));

        return $this->response();
    }
}

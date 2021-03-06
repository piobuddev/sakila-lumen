<?php declare(strict_types=1);


namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBusInterface;
use Sakila\Domain\Store\Service\Request\AddStoreRequest;
use Sakila\Domain\Store\Service\Request\RemoveStoreRequest;
use Sakila\Domain\Store\Service\Request\ShowStoreRequest;
use Sakila\Domain\Store\Service\Request\ShowStoresRequest;
use Sakila\Domain\Store\Service\Request\UpdateStoreRequest;

class StoreController extends AbstractController
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
     * @param int $storeId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $storeId): Response
    {
        $store = $this->commandBus->execute(new ShowStoreRequest($storeId));

        return $this->response($store);
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
        $stores   = $this->commandBus->execute(new ShowStoresRequest($page, $pageSize));

        return $this->response($stores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $store = $this->commandBus->execute(new AddStoreRequest((array)$request->post()));

        return $this->response($store, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $storeId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $storeId, Request $request): Response
    {
        $store = $this->commandBus->execute(new UpdateStoreRequest($storeId, (array)$request->post()));

        return $this->response($store);
    }

    /**
     * @param int $storeId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $storeId): Response
    {
        $this->commandBus->execute(new RemoveStoreRequest($storeId));

        return $this->response();
    }
}

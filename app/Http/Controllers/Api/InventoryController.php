<?php declare(strict_types=1);


namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBusInterface;
use Sakila\Domain\Inventory\Service\Request\AddInventoryRequest;
use Sakila\Domain\Inventory\Service\Request\RemoveInventoryRequest;
use Sakila\Domain\Inventory\Service\Request\ShowInventoriesRequest;
use Sakila\Domain\Inventory\Service\Request\ShowInventoryRequest;
use Sakila\Domain\Inventory\Service\Request\UpdateInventoryRequest;

class InventoryController extends AbstractController
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
     * @param int $inventoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $inventoryId): Response
    {
        $inventory = $this->commandBus->execute(new ShowInventoryRequest($inventoryId));

        return $this->response($inventory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page        = (int)$request->query('page', self::DEFAULT_PAGE);
        $pageSize    = (int)$request->query('page_size', self::DEFAULT_PAGE_SIZE);
        $inventories = $this->commandBus->execute(new ShowInventoriesRequest($page, $pageSize));

        return $this->response($inventories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $inventory = $this->commandBus->execute(new AddInventoryRequest((array)$request->post()));

        return $this->response($inventory, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $inventoryId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $inventoryId, Request $request): Response
    {
        $inventory = $this->commandBus->execute(new UpdateInventoryRequest($inventoryId, (array)$request->post()));

        return $this->response($inventory);
    }

    /**
     * @param int $inventoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $inventoryId): Response
    {
        $this->commandBus->execute(new RemoveInventoryRequest($inventoryId));

        return $this->response();
    }
}

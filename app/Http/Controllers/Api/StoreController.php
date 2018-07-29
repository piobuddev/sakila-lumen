<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Store\Commands\AddStoreCommand;
use Sakila\Domain\Store\Commands\UpdateStoreCommand;
use Sakila\Domain\Store\Repository\StoreRepository;
use Sakila\Transformer\StoreTransformer;
use Sakila\Transformer\Transformer;

class StoreController extends AbstractController
{
    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Store\Repository\StoreRepository $repository
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(StoreRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $storeId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $storeId): Response
    {
        $store = $this->repository->get($storeId);

        return $this->response($this->item($store, StoreTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page     = (int)$request->query('page', 1);
        $pageSize = (int)$request->query('page_size', 15);
        $items    = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();
        $stores   = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($stores, StoreTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $store = $commandBus->execute(new AddStoreCommand($request->post()));

        return $this->response($this->item($store, StoreTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $storeId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $storeId, Request $request, CommandBus $commandBus): Response
    {
        $store = $commandBus->execute(new UpdateStoreCommand($storeId, $request->post()));

        return $this->response($this->item($store, StoreTransformer::class));
    }

    /**
     * @param int $storeId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $storeId): Response
    {
        $this->repository->remove($storeId);

        return $this->response();
    }
}

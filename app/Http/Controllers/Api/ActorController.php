<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Transformer\Transformer;

class ActorController extends AbstractController
{
    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Actor\Repository\ActorRepository $repository
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(ActorRepository $repository, Transformer $transformer)
    {
        $this->repository  = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $actorId): Response
    {
        return $this->response($this->repository->get($actorId));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page      = (int)$request->query('page', 1);
        $pageSize  = (int)$request->query('page_size', 15);
        $items     = $this->repository->all($page, $pageSize);
        $total     = $this->repository->count();

        return $this->response(new LengthAwarePaginator($items, $total, $pageSize, $page));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $actor = $commandBus->execute(new AddActorCommand($request->post()));

        return $this->response($actor, Response::HTTP_CREATED);
    }

    /**
     * @param int                            $actorId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $actorId, Request $request, CommandBus $commandBus): Response
    {
        $actor = $commandBus->execute(new UpdateActorCommand($actorId, $request->post()));

        return $this->response($actor);
    }

    /**
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $actorId): Response
    {
        $this->repository->remove($actorId);

        return $this->response();
    }
}

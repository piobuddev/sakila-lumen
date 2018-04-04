<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;

class ActorController
{
    /**
     * @var \Sakila\Domain\Actor\Repository\ActorRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Actor\Repository\ActorRepositoryInterface $repository
     */
    public function __construct(ActorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $actorId): Response
    {
        $actor = $this->repository->get($actorId);

        return new Response($actor, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $actors = $this->repository->all();

        return new Response($actors, Response::HTTP_OK);
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

        return new Response($actor, Response::HTTP_CREATED);
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

        return new Response($actor, Response::HTTP_OK);
    }

    /**
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $actorId): Response
    {
        $this->repository->remove($actorId);

        return new Response(null, Response::HTTP_OK);
    }
}

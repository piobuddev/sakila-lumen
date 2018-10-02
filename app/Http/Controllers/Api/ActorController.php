<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Actor\Service\Request\AddActorRequest;
use Sakila\Domain\Actor\Service\Request\RemoveActorRequest;
use Sakila\Domain\Actor\Service\Request\ShowActorRequest;
use Sakila\Domain\Actor\Service\Request\ShowActorsRequest;
use Sakila\Domain\Actor\Service\Request\UpdateActorRequest;

class ActorController extends AbstractController
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
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $actorId): Response
    {
        $actor = $this->commandBus->execute(new ShowActorRequest($actorId));

        return $this->response($actor);
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
        $actors   = $this->commandBus->execute(new ShowActorsRequest($page, $pageSize));

        return $this->response($actors);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $actor = $this->commandBus->execute(new AddActorRequest($request->post()));

        return $this->response($actor, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $actorId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $actorId, Request $request): Response
    {
        $actor = $this->commandBus->execute(new UpdateActorRequest($actorId, $request->post()));

        return $this->response($actor);
    }

    /**
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $actorId): Response
    {
        $this->commandBus->execute(new RemoveActorRequest($actorId));

        return $this->response();
    }
}

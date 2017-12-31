<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Response;
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
}

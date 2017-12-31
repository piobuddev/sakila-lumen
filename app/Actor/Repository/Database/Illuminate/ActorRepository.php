<?php declare(strict_types=1);

namespace Sakila\Actor\Repository\Database\Illuminate;

use Sakila\Actor;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class ActorRepository extends AbstractDatabaseRepository implements ActorRepositoryInterface
{
    protected $primaryKey = 'actor_id';
}

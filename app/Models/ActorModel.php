<?php declare(strict_types=1);

namespace Sakila\Models;

class ActorModel extends AbstractModel
{
    protected $table = 'actor';

    protected $primaryKey = 'actor_id';
}

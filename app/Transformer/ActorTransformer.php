<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\ActorModel;

class ActorTransformer extends TransformerAbstract
{
    /**
     * @param \Sakila\Models\ActorModel $actor
     *
     * @return array
     */
    public function transform(ActorModel $actor): array
    {
        return [
            'actorId'   => $actor->getAttribute('actor_id'),
            'firstName' => $actor->getAttribute('first_name'),
            'lastName'  => $actor->getAttribute('last_name'),
        ];
    }
}

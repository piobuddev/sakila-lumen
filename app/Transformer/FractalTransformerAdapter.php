<?php declare(strict_types=1);

namespace Sakila\Transformer;

use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Sakila\Entity\EntityInterface;

class FractalTransformerAdapter implements Transformer
{
    /**
     * @var \League\Fractal\Manager
     */
    private $manager;

    /**
     * @param \League\Fractal\Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param mixed $entity
     *
     * @return array
     */
    public function transform($entity): array
    {
        $simpleTransformer = function (EntityInterface $data) {
            return $data->jsonSerialize();
        };

        $resourceClass = $entity instanceof EntityInterface ? Item::class : Collection::class;
        /** @var \League\Fractal\Resource\ResourceAbstract $resource */
        $resource      = new $resourceClass($entity, $simpleTransformer);

        if ($resource instanceof Collection && $entity instanceof LengthAwarePaginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($entity));
        }

        return $this->manager->createData($resource)->toArray();
    }
}

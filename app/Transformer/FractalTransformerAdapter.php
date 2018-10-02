<?php declare(strict_types=1);

namespace Sakila\Transformer;

use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Lumen\Application;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use Sakila\Entity\EntityInterface;

class FractalTransformerAdapter implements Transformer
{
    /**
     * @var \League\Fractal\Manager
     */
    private $manager;

    /**
     * @var \Laravel\Lumen\Application
     */
    private $application;

    /**
     * @param \League\Fractal\Manager    $manager
     * @param \Laravel\Lumen\Application $application
     */
    public function __construct(Manager $manager, Application $application)
    {
        $manager->setSerializer(new ArraySerializer());

        $this->manager     = $manager;
        $this->application = $application;
    }

    /**
     * @param mixed       $data
     * @param string|null $transformer
     *
     * @return array
     */
    public function item($data, string $transformer = null): array
    {
        $item = new Item($data, $this->resolveTransformer($transformer));

        return $this->manager->createData($item)->toArray();
    }

    /**
     * @param mixed    $data
     * @param string   $transformer
     * @param int|null $page
     * @param int|null $pageSize
     * @param int|null $total
     *
     * @return array
     */
    public function collection(
        $data,
        string $transformer = null,
        int $page = null,
        int $pageSize = null,
        int $total = null
    ): array {
        $collection = new Collection($data, $this->resolveTransformer($transformer));
        if (null !== $page) {
            $collection->setPaginator(
                new IlluminatePaginatorAdapter(
                    new LengthAwarePaginator($data, $total, $pageSize, $page)
                )
            );
        }

        return $this->manager->createData($collection)->toArray();
    }

    /**
     * @param string|null $transformer
     *
     * @return \Closure|mixed
     */
    private function resolveTransformer(string $transformer = null)
    {
        if (null === $transformer) {
            return $this->getSimpleTransformer();
        }

        return $this->application->make($transformer);
    }

    /**
     * @return \Closure
     */
    private function getSimpleTransformer(): \Closure
    {
        return function (EntityInterface $entity) {
            return $entity->jsonSerialize();
        };
    }
}

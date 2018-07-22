<?php declare(strict_types=1);

namespace Sakila\Entity;

use Illuminate\Database\Eloquent\Model;
use Sakila\Exceptions\UnexpectedValueException;

class IlluminateFactoryAdapter implements FactoryInterface
{

    /**
     * @param string $resource
     * @param array  $arguments
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\UnexpectedValueException
     */
    public function create(string $resource, array $arguments = []): EntityInterface
    {
        $model = $this->getModel($resource);
        if (!$model instanceof EntityInterface) {
            throw new UnexpectedValueException();
        }

        return $model->forceFill($arguments);
    }

    /**
     * @param string $resource
     * @param array  $items
     *
     * @return array
     */
    public function hydrate(string $resource, array $items): array
    {
        return array_map(
            function ($item) use ($resource) {
                if ($item instanceof EntityInterface) {
                    return $item;
                }

                return $this->create($resource, (array) $item);
            },
            $items
        );
    }

    /**
     * @param string $resource
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getModel(string $resource): Model
    {
        $model = 'Sakila\Models\\' . ucfirst($resource) . 'Model';

        return new $model();
    }
}

<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Store\Validator\StoreValidator as StoreValidatorInterface;

class StoreValidator extends AbstractValidator implements StoreValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        //todo: implement
        return [
            'store_id' => 'sometimes|required|exists:store,store_id',
        ];
    }
}

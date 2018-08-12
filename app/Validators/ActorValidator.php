<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Actor\Validator\ActorValidator as ActorValidatorInterface;

class ActorValidator extends AbstractValidator implements ActorValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id'        => 'sometimes|required|exists:actor,actor_id',
            'firstName' => 'required|alpha|string|max:45',
            'lastName'  => 'required|alpha|string|max:45',
        ];
    }
}

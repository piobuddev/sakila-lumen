<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Country\Validator\CountryValidator as CountryValidatorInterface;

class CountryValidator extends AbstractValidator implements CountryValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id'      => 'sometimes|required|exists:category,category_id',
            'country' => ['required', 'max:50'],
        ];
    }
}

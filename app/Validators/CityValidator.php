<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\City\Validator\CityValidator as CityValidatorInterface;

class CityValidator extends AbstractValidator implements CityValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id'        => 'sometimes|required|exists:city,city_id',
            'city'      => 'required|max:50',
            'countryId' => 'required|exists:country,country_id',
        ];
    }
}

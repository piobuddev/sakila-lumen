<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Address\Validator\AddressValidator as AddressValidatorInterface;

class AddressValidator extends AbstractValidator implements AddressValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id'         => 'sometimes|required|exists:address,address_id',
            'address'    => ['required', 'max:50'],
            'address2'   => ['max:50'],
            'district'   => ['required', 'max:20'],
            'cityId'     => ['required'],
            'postalCode' => ['max:10'],
            'phone'      => ['required', 'max:20'],
        ];
    }
}

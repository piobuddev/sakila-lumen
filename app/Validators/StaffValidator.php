<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Staff\Validator\StaffValidatorInterface;

class StaffValidator extends AbstractValidator implements StaffValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'staffId'   => 'sometimes|required|exists:staff,staff_id',
            'firstName' => 'required|alpha|string|max:45',
            'lastName'  => 'required|alpha|string|max:45',
            'addressId' => 'required|exists:address,address_id',
            'picture'   => '',
            'email'     => '',
            'storeId'   => 'required|exists:store,store_id',
            'active'    => 'boolean',
            'username'  => 'string|max:15',
            'password'  => '',
        ];
    }
}

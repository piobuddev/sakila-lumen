<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Customer\Validator\CustomerValidator as CustomerValidatorInterface;

class CustomerValidator extends AbstractValidator implements CustomerValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'customerId' => 'sometimes|required|exists:customer,customer_id',
            'storeId'    => 'required|exists:store,store_id',
            'firstName'  => 'required|alpha|string|max:45',
            'lastName'   => 'required|alpha|string|max:45',
            'email'      => 'string|max:50|email',
            'addressId'  => 'required|exists:address,address_id',
            'active'     => 'boolean',
            'createDate' => 'date',
        ];
    }
}

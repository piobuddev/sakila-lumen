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
        // todo: add validation
        return [
            'customerId' => '',
            'storeId'    => '',
            'firstName'  => '',
            'lastName'   => '',
            'email'      => '',
            'addressId'  => '',
            'active'     => '',
            'createDate' => '',
        ];
    }
}

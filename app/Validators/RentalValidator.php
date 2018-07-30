<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Rental\Validator\RentalValidator as RentalValidatorInterface;

class RentalValidator extends AbstractValidator implements RentalValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'rentalId'    => '',
            'rentalDate'  => '',
            'inventoryId' => '',
            'customerId'  => '',
            'returnDate'  => '',
            'staffId'     => '',
        ];
    }
}

<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Rental\Validator\RentalValidatorInterface;

class RentalValidator extends AbstractValidator implements RentalValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'rentalId'    => 'sometimes|required|exists:rental,rental_id',
            'rentalDate'  => 'required|date',
            'inventoryId' => 'required|exists:inventory,inventory_id',
            'customerId'  => 'required|exists:customer,customer_id',
            'returnDate'  => 'date',
            'staffId'     => 'required|exists:staff,staff_id',
        ];
    }
}

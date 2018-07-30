<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\RentalModel;

class RentalTransformer extends TransformerAbstract
{
    /**
     * @param \Sakila\Models\RentalModel $rental
     *
     * @return array
     */
    public function transform(RentalModel $rental): array
    {
        return [
            'rentalId'    => $rental->getAttribute('rental_id'),
            'rentalDate'  => $rental->getAttribute('rental_date'),
            'inventoryId' => $rental->getAttribute('inventory_id'),
            'customerId'  => $rental->getAttribute('customer_id'),
            'returnDate'  => $rental->getAttribute('return_date'),
            'staffId'     => $rental->getAttribute('staff_id'),
        ];
    }
}

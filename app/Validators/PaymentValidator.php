<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Payment\Validator\PaymentValidator as PaymentValidatorInterface;

class PaymentValidator extends AbstractValidator implements PaymentValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'paymentId'   => 'sometimes|required|exists:payment,payment_id',
            'customerId'  => 'required|exists:customer,customer_id',
            'staffId'     => 'required|exists:staff,staff_id',
            'rentalId'    => 'sometimes|required|exists:rental,rental_id',
            'amount'      => 'required|numeric',
            'paymentDate' => 'required|date',
        ];
    }
}

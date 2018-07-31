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
            'paymentId'   => '',
            'customerId'  => '',
            'staffId'     => '',
            'rentalId'    => '',
            'amount'      => '',
            'paymentDate' => '',
        ];
    }
}

<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\PaymentModel;

class PaymentTransformer extends TransformerAbstract
{
    /**
     * @param \Sakila\Models\PaymentModel $payment
     *
     * @return array
     */
    public function transform(PaymentModel $payment): array
    {
        return [
            'paymentId'   => $payment->getAttribute('payment_id'),
            'customerId'  => $payment->getAttribute('customer_id'),
            'staffId'     => $payment->getAttribute('staff_id'),
            'rentalId'    => $payment->getAttribute('rental_id'),
            'amount'      => $payment->getAttribute('amount'),
            'paymentDate' => $payment->getAttribute('payment_date'),
        ];
    }
}

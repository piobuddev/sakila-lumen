<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Payment\Service\Request\AddPaymentRequest;
use Sakila\Domain\Payment\Service\Request\RemovePaymentRequest;
use Sakila\Domain\Payment\Service\Request\ShowPaymentRequest;
use Sakila\Domain\Payment\Service\Request\ShowPaymentsRequest;
use Sakila\Domain\Payment\Service\Request\UpdatePaymentRequest;

class PaymentController extends AbstractController
{
    /**
     * @var \Sakila\Command\Bus\CommandBus
     */
    private $commandBus;

    /**
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param int $paymentId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $paymentId): Response
    {
        $payment = $this->commandBus->execute(new ShowPaymentRequest($paymentId));

        return $this->response($payment);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page     = (int)$request->query('page', self::DEFAULT_PAGE);
        $pageSize = (int)$request->query('page_size', self::DEFAULT_PAGE_SIZE);
        $payments = $this->commandBus->execute(new ShowPaymentsRequest($page, $pageSize));

        return $this->response($payments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $payment = $this->commandBus->execute(new AddPaymentRequest((array)$request->post()));

        return $this->response($payment, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $paymentId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $paymentId, Request $request): Response
    {
        $payment = $this->commandBus->execute(new UpdatePaymentRequest($paymentId, (array)$request->post()));

        return $this->response($payment);
    }

    /**
     * @param int $paymentId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $paymentId): Response
    {
        $this->commandBus->execute(new RemovePaymentRequest($paymentId));

        return $this->response();
    }
}

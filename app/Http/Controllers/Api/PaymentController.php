<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Payment\Commands\AddPaymentCommand;
use Sakila\Domain\Payment\Commands\UpdatePaymentCommand;
use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Transformer\PaymentTransformer;
use Sakila\Transformer\Transformer;

class PaymentController extends AbstractController
{
    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Payment\Repository\PaymentRepository $repository
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(PaymentRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $paymentId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $paymentId): Response
    {
        $payment = $this->repository->get($paymentId);

        return $this->response($this->item($payment, PaymentTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page     = (int)$request->query('page', 1);
        $pageSize = (int)$request->query('page_size', 15);
        $items    = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();
        $payments = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($payments, PaymentTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $payment = $commandBus->execute(new AddPaymentCommand($request->post()));

        return $this->response($this->item($payment, PaymentTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $paymentId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $paymentId, Request $request, CommandBus $commandBus): Response
    {
        $payment = $commandBus->execute(new UpdatePaymentCommand($paymentId, $request->post()));

        return $this->response($this->item($payment, PaymentTransformer::class));
    }

    /**
     * @param int $paymentId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $paymentId): Response
    {
        $this->repository->remove($paymentId);

        return $this->response();
    }
}

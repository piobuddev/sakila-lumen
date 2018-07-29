<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Staff\Commands\AddStaffCommand;
use Sakila\Domain\Staff\Commands\UpdateStaffCommand;
use Sakila\Domain\Staff\Repository\StaffRepository;
use Sakila\Transformer\StaffTransformer;
use Sakila\Transformer\Transformer;

class StaffController extends AbstractController
{
    /**
     * @var \Sakila\Domain\Staff\Repository\StaffRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Staff\Repository\StaffRepository $repository
     * @param \Sakila\Transformer\Transformer               $transformer
     */
    public function __construct(StaffRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $staffId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $staffId): Response
    {
        $staff = $this->repository->get($staffId);

        return $this->response($this->item($staff, StaffTransformer::class));
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
        $staff   = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($staff, StaffTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $staff = $commandBus->execute(new AddStaffCommand($request->post()));

        return $this->response($this->item($staff, StaffTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $staffId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $staffId, Request $request, CommandBus $commandBus): Response
    {
        $staff = $commandBus->execute(new UpdateStaffCommand($staffId, $request->post()));

        return $this->response($this->item($staff, StaffTransformer::class));
    }

    /**
     * @param int $staffId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $staffId): Response
    {
        $this->repository->remove($staffId);

        return $this->response();
    }
}

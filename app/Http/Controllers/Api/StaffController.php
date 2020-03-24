<?php declare(strict_types=1);


namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBusInterface;
use Sakila\Domain\Staff\Service\Request\AddStaffRequest;
use Sakila\Domain\Staff\Service\Request\RemoveStaffRequest;
use Sakila\Domain\Staff\Service\Request\ShowStaffMemberRequest;
use Sakila\Domain\Staff\Service\Request\ShowStaffRequest;
use Sakila\Domain\Staff\Service\Request\UpdateStaffRequest;

class StaffController extends AbstractController
{
    /**
     * @var \Sakila\Command\Bus\CommandBusInterface
     */
    private $commandBus;

    /**
     * @param \Sakila\Command\Bus\CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param int $staffId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $staffId): Response
    {
        $staff = $this->commandBus->execute(new ShowStaffMemberRequest($staffId));

        return $this->response($staff);
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
        $staff    = $this->commandBus->execute(new ShowStaffRequest($page, $pageSize));

        return $this->response($staff);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $staff = $this->commandBus->execute(new AddStaffRequest((array)$request->post()));

        return $this->response($staff, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $staffId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $staffId, Request $request): Response
    {
        $staff = $this->commandBus->execute(new UpdateStaffRequest($staffId, (array)$request->post()));

        return $this->response($staff);
    }

    /**
     * @param int $staffId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $staffId): Response
    {
        $this->commandBus->execute(new RemoveStaffRequest($staffId));

        return $this->response();
    }
}

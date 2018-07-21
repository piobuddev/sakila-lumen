<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Language\Commands\AddLanguageCommand;
use Sakila\Domain\Language\Commands\UpdateLanguageCommand;
use Sakila\Domain\Language\Repository\LanguageRepository;
use Sakila\Transformer\Transformer;

class LanguageController extends AbstractController
{
    /**
     * @var \Sakila\Domain\Language\Repository\LanguageRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Language\Repository\LanguageRepository $repository
     * @param \Sakila\Transformer\Transformer                       $transformer
     */
    public function __construct(LanguageRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $languageId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $languageId): Response
    {
        return $this->response($this->repository->get($languageId));
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

        return $this->response(new LengthAwarePaginator($items, $total, $pageSize, $page));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $language = $commandBus->execute(new AddLanguageCommand($request->post()));

        return $this->response($language, Response::HTTP_CREATED);
    }

    /**
     * @param int                            $languageId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $languageId, Request $request, CommandBus $commandBus): Response
    {
        $language = $commandBus->execute(new UpdateLanguageCommand($languageId, $request->post()));

        return $this->response($language);
    }

    /**
     * @param int $languageId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $languageId): Response
    {
        $this->repository->remove($languageId);

        return $this->response();
    }
}

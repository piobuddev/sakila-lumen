<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Film\Commands\AddFilmCommand;
use Sakila\Domain\Film\Commands\UpdateFilmCommand;
use Sakila\Domain\Film\Repository\FilmRepository;
use Sakila\Transformer\FilmTransformer;
use Sakila\Transformer\Transformer;

class FilmController extends AbstractController
{
    /**
     * @var \Sakila\Domain\Film\Repository\FilmRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Film\Repository\FilmRepository $repository
     * @param \Sakila\Transformer\Transformer               $transformer
     */
    public function __construct(FilmRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $filmId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $filmId): Response
    {
        $film = $this->repository->get($filmId);

        return $this->response($this->item($film, FilmTransformer::class));
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
        $films    = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($films, FilmTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $film = $commandBus->execute(new AddFilmCommand($request->post()));

        return $this->response($this->item($film, FilmTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $filmId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $filmId, Request $request, CommandBus $commandBus): Response
    {
        $film = $commandBus->execute(new UpdateFilmCommand($filmId, $request->post()));

        return $this->response($this->item($film, FilmTransformer::class));
    }

    /**
     * @param int $filmId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $filmId): Response
    {
        $this->repository->remove($filmId);

        return $this->response();
    }
}

<?php declare(strict_types=1);


namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBusInterface;
use Sakila\Domain\Film\Service\Request\AddFilmRequest;
use Sakila\Domain\Film\Service\Request\RemoveFilmRequest;
use Sakila\Domain\Film\Service\Request\ShowFilmRequest;
use Sakila\Domain\Film\Service\Request\ShowFilmsRequest;
use Sakila\Domain\Film\Service\Request\UpdateFilmRequest;

class FilmController extends AbstractController
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
     * @param int $filmId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $filmId): Response
    {
        $film = $this->commandBus->execute(new ShowFilmRequest($filmId));

        return $this->response($film);
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
        $films    = $this->commandBus->execute(new ShowFilmsRequest($page, $pageSize));

        return $this->response($films);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $film = $this->commandBus->execute(new AddFilmRequest((array)$request->post()));

        return $this->response($film, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $filmId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $filmId, Request $request): Response
    {
        $film = $this->commandBus->execute(new UpdateFilmRequest($filmId, (array)$request->post()));

        return $this->response($film);
    }

    /**
     * @param int $filmId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $filmId): Response
    {
        $this->commandBus->execute(new RemoveFilmRequest($filmId));

        return $this->response();
    }
}

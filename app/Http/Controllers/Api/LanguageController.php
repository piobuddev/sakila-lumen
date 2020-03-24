<?php declare(strict_types=1);


namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBusInterface;
use Sakila\Domain\Language\Service\Request\AddLanguageRequest;
use Sakila\Domain\Language\Service\Request\RemoveLanguageRequest;
use Sakila\Domain\Language\Service\Request\ShowLanguageRequest;
use Sakila\Domain\Language\Service\Request\ShowLanguagesRequest;
use Sakila\Domain\Language\Service\Request\UpdateLanguageRequest;

class LanguageController extends AbstractController
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
     * @param int $languageId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $languageId): Response
    {
        $language = $this->commandBus->execute(new ShowLanguageRequest($languageId));

        return $this->response($language);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page      = (int)$request->query('page', self::DEFAULT_PAGE);
        $pageSize  = (int)$request->query('page_size', self::DEFAULT_PAGE_SIZE);
        $languages = $this->commandBus->execute(new ShowLanguagesRequest($page, $pageSize));

        return $this->response($languages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $language = $this->commandBus->execute(new AddLanguageRequest((array)$request->post()));

        return $this->response($language, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $languageId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $languageId, Request $request): Response
    {
        $language = $this->commandBus->execute(new UpdateLanguageRequest($languageId, (array)$request->post()));

        return $this->response($language);
    }

    /**
     * @param int $languageId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $languageId): Response
    {
        $this->commandBus->execute(new RemoveLanguageRequest($languageId));

        return $this->response();
    }
}

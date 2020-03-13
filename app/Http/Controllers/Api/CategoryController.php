<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Category\Service\Request\AddCategoryRequest;
use Sakila\Domain\Category\Service\Request\RemoveCategoryRequest;
use Sakila\Domain\Category\Service\Request\ShowCategoriesRequest;
use Sakila\Domain\Category\Service\Request\ShowCategoryRequest;
use Sakila\Domain\Category\Service\Request\UpdateCategoryRequest;

class CategoryController extends AbstractController
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
     * @param int $categoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $categoryId): Response
    {
        $category = $this->commandBus->execute(new ShowCategoryRequest($categoryId));

        return $this->response($category);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page       = (int)$request->query('page', self::DEFAULT_PAGE);
        $pageSize   = (int)$request->query('page_size', self::DEFAULT_PAGE_SIZE);
        $categories = $this->commandBus->execute(new ShowCategoriesRequest($page, $pageSize));

        return $this->response($categories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $category = $this->commandBus->execute(new AddCategoryRequest((array)$request->post()));

        return $this->response($category, Response::HTTP_CREATED);
    }

    /**
     * @param int                      $categoryId
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $categoryId, Request $request): Response
    {
        $category = $this->commandBus->execute(new UpdateCategoryRequest($categoryId, (array)$request->post()));

        return $this->response($category);
    }

    /**
     * @param int $categoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $categoryId): Response
    {
        $this->commandBus->execute(new RemoveCategoryRequest($categoryId));

        return $this->response();
    }
}

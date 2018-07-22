<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Sakila\Command\Bus\CommandBus;
use Sakila\Domain\Category\Commands\AddCategoryCommand;
use Sakila\Domain\Category\Commands\UpdateCategoryCommand;
use Sakila\Domain\Category\Repository\CategoryRepository;
use Sakila\Transformer\CategoryTransformer;
use Sakila\Transformer\Transformer;

class CategoryController extends AbstractController
{
    /**
     * @var \Sakila\Domain\Category\Repository\CategoryRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Category\Repository\CategoryRepository $repository
     * @param \Sakila\Transformer\Transformer                       $transformer
     */
    public function __construct(CategoryRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $categoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $categoryId): Response
    {
        $category = $this->repository->get($categoryId);

        return $this->response($this->item($category, CategoryTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page       = (int)$request->query('page', 1);
        $pageSize   = (int)$request->query('page_size', 15);
        $items      = $this->repository->all($page, $pageSize);
        $total      = $this->repository->count();
        $categories = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($categories, CategoryTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $category = $commandBus->execute(new AddCategoryCommand($request->post()));

        return $this->response($this->item($category, CategoryTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $categoryId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \Sakila\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $categoryId, Request $request, CommandBus $commandBus): Response
    {
        $category = $commandBus->execute(new UpdateCategoryCommand($categoryId, $request->post()));

        return $this->response($this->item($category, CategoryTransformer::class));
    }

    /**
     * @param int $categoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $categoryId): Response
    {
        $this->repository->remove($categoryId);

        return $this->response();
    }
}

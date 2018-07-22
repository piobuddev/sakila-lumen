<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\CategoryModel;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * @param \Sakila\Models\CategoryModel $category
     *
     * @return array
     */
    public function transform(CategoryModel $category): array
    {
        return [
            'categoryId' => $category->getAttribute('category_id'),
            'name'       => $category->getAttribute('name'),
        ];
    }
}

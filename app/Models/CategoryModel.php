<?php declare(strict_types=1);

namespace Sakila\Models;

class CategoryModel extends AbstractModel
{
    protected $table = 'category';

    protected $primaryKey = 'category_id';
}

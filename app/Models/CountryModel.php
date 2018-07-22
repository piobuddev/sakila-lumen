<?php declare(strict_types=1);

namespace Sakila\Models;

use Illuminate\Database\Eloquent\Model;
use Sakila\Entity\EntityInterface;

class CountryModel extends Model implements EntityInterface
{
    /**
     * @var string
     */
    protected $table = 'country';

    /**
     * @var string
     */
    protected $primaryKey = 'country_id';
}

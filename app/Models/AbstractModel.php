<?php declare(strict_types=1);

namespace Sakila\Models;

use Illuminate\Database\Eloquent\Model;
use Sakila\Entity\EntityInterface;

class AbstractModel extends Model implements EntityInterface
{
}

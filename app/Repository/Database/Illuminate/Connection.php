<?php declare(strict_types=1);

namespace Sakila\Repository\Database\Illuminate;

use Illuminate\Database\DatabaseManager;
use Sakila\Exceptions\Database\NotFoundException;
use Sakila\Repository\Database\ConnectionInterface;
use Sakila\Repository\Database\Table\TableInterface;

class Connection implements ConnectionInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var \Illuminate\Database\Connection
     */
    private $connection;

    /**
     * @param \Illuminate\Database\DatabaseManager $connection
     */
    public function __construct(DatabaseManager $connection)
    {
        $this->connection = $connection->connection();
    }

    /**
     * @param \Sakila\Repository\Database\Table\TableInterface $table
     * @param int                                              $entityId
     *
     * @return array
     * @throws \Sakila\Exceptions\Database\NotFoundException
     */
    public function fetch(TableInterface $table, int $entityId): array
    {
        $result = $this->connection
            ->table($table->getName())
            ->where($table->getPrimaryKey(), '=', $entityId)
            ->first();

        if (null === $result) {
            throw new NotFoundException('Row (ID:%s) not found in `%s` table', [$entityId, $table->getName()]);
        }

        return (array)$result;
    }
}

<?php declare(strict_types=1);

namespace Sakila\Repository\Database\Illuminate\Query;

use Illuminate\Database\Connection;
use Sakila\Repository\Database\Query\BuilderInterface;

class Builder implements BuilderInterface
{
    /**
     * @var \Illuminate\Database\Connection
     */
    private $connection;

    /**
     * @var \Illuminate\Database\Query\Builder
     */
    private $query;

    /**
     * @param \Illuminate\Database\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        $this->query = $this->connection->query();
    }

    /**
     * @param array $columns
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function select(array $columns): BuilderInterface
    {
        $this->query->select($columns);

        return $this;
    }

    /**
     * @param string $table
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function from(string $table): BuilderInterface
    {
        $this->query->from($table);

        return $this;
    }

    /**
     * @param array $where
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function where(array $where): BuilderInterface
    {
        $this->query->where($where);

        return $this;
    }

    /**
     * @param array $order
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function order(array $order): BuilderInterface
    {
        list($column, $dir) = array_pad($order, 2, 'asc');

        $this->query->orderBy($column, $dir);

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function limit(int $limit): BuilderInterface
    {
        $this->query->limit($limit);

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->query->get()->toArray();
    }
}

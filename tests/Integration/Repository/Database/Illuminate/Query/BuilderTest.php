<?php declare(strict_types=1);

namespace Sakila\Test\Repository\Database\Illuminate\Query;

use Illuminate\Database\DatabaseManager;
use Sakila\Repository\Database\Illuminate\Query\Builder;
use Sakila\Test\BaseIntegrationTestCase;

class BuilderTest extends BaseIntegrationTestCase
{
    private const TABLE = 'actor';

    /**
     * @var \Sakila\Repository\Database\Illuminate\Query\Builder
     */
    private $cut;

    /**
     * @var array
     */
    private $rows;

    public function setUp()
    {
        parent::setUp();

        $this->cut  = new Builder($this->app->make(DatabaseManager::class)->connection());
        $this->rows = $this->add(self::TABLE, 20);
    }

    public function testSelectColumns()
    {
        $column  = 'first_name';
        $results = $this->cut->select([$column])->from(self::TABLE)->get();
        $result  = (array) array_pop($results);

        $this->assertCount(1, $result);
        $this->assertArrayHasKey($column, $result);
    }

    public function testWhere()
    {
        $actor = array_pop($this->rows);
        $results = $this->cut->from(self::TABLE)->where(['actor_id' => $actor['actor_id']])->get();
        $result = array_pop($results);

        $this->assertEquals($actor['first_name'], $result->first_name);
        $this->assertEquals($actor['last_name'], $result->last_name);
    }

    public function testOrderAsc()
    {
        $results = $this->cut->from(self::TABLE)->order(['actor_id', 'ASC'])->get();

        $this->assertEquals(1, $results[0]->actor_id);
        $this->assertEquals(2, $results[1]->actor_id);
        $this->assertEquals(3, $results[2]->actor_id);
    }

    public function testOrderDesc()
    {
        $results = $this->cut->from(self::TABLE)->order(['actor_id', 'DESC'])->get();

        $this->assertEquals(20, $results[0]->actor_id);
        $this->assertEquals(19, $results[1]->actor_id);
        $this->assertEquals(18, $results[2]->actor_id);
    }

    public function testLimit()
    {
        $results = $this->cut->from(self::TABLE)->limit(5)->get();

        $this->assertCount(5, $results);
    }
}

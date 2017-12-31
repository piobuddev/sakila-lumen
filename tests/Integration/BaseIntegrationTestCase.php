<?php declare(strict_types=1);

namespace Sakila\Test;

use Laravel\Lumen\Testing\TestCase;
use RepositoryTester\DataFactory\DataFactoryAwareInterface;
use RepositoryTester\DataFactory\DataFactoryAwareTrait;
use RepositoryTester\Repository\RepositoryAwareInterface;
use RepositoryTester\RepositoryAssertTrait;

class BaseIntegrationTestCase extends TestCase implements RepositoryAwareInterface, DataFactoryAwareInterface
{
    use RepositoryAssertTrait;
    use DataFactoryAwareTrait;

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        return require __DIR__ . '/../../bootstrap/app.php';
    }

    public function tearDown()
    {
        $this->clearTables();

        parent::tearDown();
    }

    /**
     * @param string $table
     * @param int    $times
     * @param array  $arguments
     *
     * @return array
     */
    protected function add(string $table, int $times = 1, array $arguments = []): array
    {
        $data = $this->getDataFactory()->create($table, $times, $arguments);

        return $this->insert($data);
    }
}

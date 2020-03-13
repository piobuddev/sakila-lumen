<?php declare(strict_types=1);

namespace Sakila\Test;

use Faker\Factory;
use PDO;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;
use RepositoryTester\DataFactory\DataFactoryAwareInterface;
use RepositoryTester\DataFactory\Definition\Container\Container;
use RepositoryTester\DataFactory\Definition\Loader\Loaders\PhpFileLoader;
use RepositoryTester\DataFactory\Factories\Faker\FakerDataFactory;
use RepositoryTester\Repository\Connection\ConnectionInterface;
use RepositoryTester\Repository\Database\Adapters\DbUnitConnectionAdapter;
use RepositoryTester\Repository\RepositoryAwareInterface;

class RepositoryAwareTestListener implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * @var \RepositoryTester\Repository\Connection\ConnectionInterface
     */
    private $connection;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param \PHPUnit\Framework\Test $test
     */
    public function startTest(Test $test): void
    {
        if ($test instanceof RepositoryAwareInterface) {
            $this->configureDatabaseAwareTest($test);
        }

        if ($test instanceof DataFactoryAwareInterface) {
            $this->configureDataFactoryTest($test);
        }
    }

    /**
     * @param \PHPUnit\Framework\TestSuite $suite
     */
    public function endTestSuite(TestSuite $suite): void
    {
        $this->closeConnection();
    }

    /**
     * @param \RepositoryTester\Repository\RepositoryAwareInterface $test
     */
    private function configureDatabaseAwareTest(RepositoryAwareInterface $test): void
    {
        $test->setConnection($this->getConnection());
    }

    /**
     * @param \RepositoryTester\DataFactory\DataFactoryAwareInterface $test
     */
    private function configureDataFactoryTest(DataFactoryAwareInterface $test): void
    {
        $generator = Factory::create();
        $container = new Container();
        $loader    = new PhpFileLoader($container, $this->config['database']['definitions']['path']);
        $loader->load($this->config['database']['definitions']['file']);

        $test->setDataFactory(new FakerDataFactory($generator, $container));
    }

    /**
     * @return \RepositoryTester\Repository\Connection\ConnectionInterface
     */
    private function getConnection(): ConnectionInterface
    {
        if (!isset($this->connection)) {
            $connection = array_pad(array_values($this->config['database']['connection']), 4, null);
            list($host, $database, $username, $password) = $connection;
            $dns     = "mysql:dbname={$database};host={$host}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_CASE               => PDO::CASE_NATURAL,
                PDO::ATTR_ORACLE_NULLS       => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            $this->connection = new DbUnitConnectionAdapter(new PDO($dns, $username, $password, $options));
        }

        return $this->connection;
    }

    private function closeConnection(): void
    {
        if (isset($this->connection)) {
            $this->getConnection()->close();
            unset($this->connection, $this->pdo);
        }

        return;
    }
}

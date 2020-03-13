<?php declare(strict_types=1);

namespace Sakila\Command;

use Illuminate\Bus\Dispatcher;
use Sakila\Command\Bus\CommandBus;

class IlluminateCommandBusAdapter implements CommandBus
{
    /**
     * @var \Illuminate\Bus\Dispatcher
     */
    private $dispatcher;

    /**
     * IlluminateBusDispatcherAdapter constructor.
     *
     * @param \Illuminate\Bus\Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param \Sakila\Command\Command $command
     *
     * @return mixed
     */
    public function execute(Command $command)
    {
        if ($handler = $this->dispatcher->getCommandHandler($command)) {
            $methodName = 'execute';
            if (method_exists($handler, $methodName)) {
                return $handler->{$methodName}($command);
            }
        }

        return $this->dispatcher->dispatchNow($command);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func([$this->dispatcher, $name], $arguments[0]);
    }
}

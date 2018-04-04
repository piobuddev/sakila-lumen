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
            $classBasename = class_basename($command);
            $method        = 'handle' . str_replace('Command', '', $classBasename);

            if (method_exists($handler, $method)) {
                return $handler->{$method}($command);
            }
        }

        return $this->dispatcher->dispatch($command);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func([$this->dispatcher, $name], $arguments[0]);
    }
}

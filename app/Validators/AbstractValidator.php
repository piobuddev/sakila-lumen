<?php declare(strict_types=1);

namespace Sakila\Validators;

use Illuminate\Contracts\Validation\Factory;
use Sakila\Exceptions\Validation\ValidationException;

abstract class AbstractValidator
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var \Illuminate\Contracts\Validation\Factory
     */
    private $factory;

    /**
     * @return array
     */
    abstract protected function getRules(): array;

    /**
     * @param \Illuminate\Contracts\Validation\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param array $data
     *
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function validate(array $data): void
    {
        $this->data = $data;

        $validator = $this->getValidator()->make(
            $data,
            $this->getRules(),
            $this->getMessages()
        );

        if ($validator->fails()) {
            throw new ValidationException($validator->getMessageBag()->first());
        }
    }

    /**
     * @return array
     */
    protected function getMessages(): array
    {
        return [];
    }

    /**
     * @return \Illuminate\Contracts\Validation\Factory
     */
    private function getValidator(): Factory
    {
        return $this->factory;
    }
}

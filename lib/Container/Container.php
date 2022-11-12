<?php
declare(strict_types=1);

namespace App\Container;

use App\Services\CommandBuilder;
use App\Services\CommandBuilderInterface;
use ReflectionClass;
use ReflectionException;

class Container
{
    private array $objects;
    private array $map;

    public function __construct()
    {
        $this->objects = [
        ];

        $this->map = [
            CommandBuilderInterface::class => CommandBuilder::class
        ];
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->objects[$id]) || class_exists($id);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws ReflectionException
     */
    public function get(string $id)
    {
        return $this->objects[$id] ?? $this->prepareObject($id);
    }

    /**
     * @throws ReflectionException
     */
    private function prepareObject(string $class)
    {

        if (key_exists($class, $this->map)) {
            $class = $this->map[$class];
        }

        $classReflector = new ReflectionClass($class);
        $constructReflector = $classReflector->getConstructor();
        if (empty($constructReflector)) {
            return new $class;
        }

        $constructArguments = $constructReflector->getParameters();
        if (empty($constructArguments)) {
            return new $class;
        }

        $args = [];
        foreach ($constructArguments as $argument) {
            $argumentType = $argument->getType()->getName();

            $args[$argument->getName()] = $this->get($argumentType);
        }

        return new $class(...array_values($args));

    }
}

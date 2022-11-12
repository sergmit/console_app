<?php

namespace App;

use App\Container\Container;
use App\Services\CommandBuilder;
use App\Services\CommandBuilderInterface;
use Exception;

class App extends Container
{
    private array $args;

    public function __construct(array $args)
    {
        unset($args[0]);
        $this->args = array_values($args);
        parent::__construct();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function execute()
    {
        /** @var CommandBuilder $commandBuilder */
        $commandBuilder = $this->get(CommandBuilderInterface::class);
        $commandBuilder->setName($this->args[0]);
        $command = $commandBuilder->build($this->args);
        $command->execute();
    }
}

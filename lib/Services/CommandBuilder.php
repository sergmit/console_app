<?php
declare(strict_types=1);

namespace App\Services;

use App\AbstractCommand;
use App\DefaultCommand;
use Exception;

class CommandBuilder implements CommandBuilderInterface
{
    private ?string $name;
    private ParamsBuilder $paramsBuilder;

    public function __construct(ParamsBuilder $paramsBuilder)
    {
        $this->paramsBuilder = $paramsBuilder;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        if (preg_match('/^[a-z]+_[a-z]+$/', $name)) {
            $this->name = $name;
        } else {
            $this->name = null;
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getCommandClass(): string
    {
        if (empty($this->name)) {
            return DefaultCommand::class;
        }

        $data = explode('_', $this->name);
        $name = '';

        foreach ($data as $item) {
            $name .= ucfirst($item);
        }

        $class = "Commands\\Commands\\{$name}Command";

        if (class_exists($class) === false) {
            throw new Exception("Command $name not found");
        }

        return $class;
    }

    /**
     * @param array $args
     * @return AbstractCommand
     * @throws Exception
     */
    public function build(array $args): AbstractCommand
    {
        $paramsCollection = $this->paramsBuilder->build($args);
        $class = $this->getCommandClass();

        /** @var AbstractCommand $command */
        $command = new $class($this->name, $paramsCollection);

        return $command;
    }
}

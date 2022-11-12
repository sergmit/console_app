<?php
declare(strict_types=1);

namespace App;

use App\Params\Argument;
use App\Params\ParamsCollection;

abstract class AbstractCommand
{
    private ?string $name;
    protected string $description = '';
    private ParamsCollection $paramsCollection;

    /**
     * @param string|null $name
     * @param ParamsCollection $paramsCollection
     */
    public function __construct(?string $name, ParamsCollection $paramsCollection)
    {
        $this->name = $name;
        $this->paramsCollection = $paramsCollection;

        if ($this->hasHelp() || get_class($this) === DefaultCommand::class) {
            echo $this;
        }
    }

    /**
     * @return void
     */
    abstract public function execute(): void;

    /**
     * @return bool
     */
    protected function hasHelp(): bool
    {
        foreach ($this->paramsCollection->getArguments() as $argument) {
            /** @var Argument $argument */
            if ($argument->getValue() === 'help') {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if ($this->name) {
            $str = PHP_EOL . "Called command: $this->name" . PHP_EOL . PHP_EOL;
        } else {
            $str = PHP_EOL;
        }

        $str .= 'Arguments:' . PHP_EOL;

        foreach ($this->paramsCollection->getArguments() as $argument) {
            $str .= $argument;
        }

        $str .= PHP_EOL . 'Options:' . PHP_EOL;

        foreach ($this->paramsCollection->getOptions() as $option) {
            $str .= $option;
        }

        $str .= PHP_EOL;
        return $str;
    }
}

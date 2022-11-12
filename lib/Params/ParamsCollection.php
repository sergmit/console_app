<?php
declare(strict_types=1);

namespace App\Params;

class ParamsCollection
{
    public array $options = [];
    public array $arguments = [];

    /**
     * @param Argument $argument
     * @return void
     */
    public function addArgument(Argument $argument)
    {
        $this->arguments[] = $argument;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param Option $option
     * @return void
     */
    public function addOption(Option $option)
    {
        $this->options[] = $option;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}

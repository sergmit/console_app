<?php
declare(strict_types=1);

namespace App\Params;

use Exception;

class Option extends AbstractParam
{
    private array $arguments = [];
    private string $name;

    /**
     * @throws Exception
     */
    public function __construct(string $str)
    {
        parent::__construct($str);
        $this->parse();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param Argument $argument
     * @return void
     */
    public function addArgument(Argument $argument): void
    {
        $this->arguments[] = $argument;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $str = '   -  ' . $this->name . PHP_EOL;
        foreach ($this->arguments as $argument) {
            /** @var Argument $argument */
            $str .= '      ' . $argument;
        }

        return $str;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function parse()
    {
        $data = explode('=', $this->str);
        if (count($data) !== 2) {
            throw new Exception("Option $this->str has invalid format");
        }
        $this->name = $data[0];
        $this->arguments[] = new Argument($data[1]);
    }
}

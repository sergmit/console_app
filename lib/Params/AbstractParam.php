<?php
declare(strict_types=1);

namespace App\Params;

abstract class AbstractParam
{
    protected string $str;

    public function __construct(string $str)
    {
        $this->str = $str;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->str;
    }

    abstract function __toString();
}

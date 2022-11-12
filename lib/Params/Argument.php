<?php
declare(strict_types=1);

namespace App\Params;

class Argument extends AbstractParam
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        return "   -  $this->str" . PHP_EOL;
    }
}

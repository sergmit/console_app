<?php
declare(strict_types=1);

namespace App\Services;

use App\Params\Argument;
use App\Params\Option;
use App\Params\ParamsCollection;
use Exception;

class ParamsBuilder
{
    private ParamsCollection $paramsCollection;

    public function __construct(ParamsCollection $paramsCollection)
    {
        $this->paramsCollection = $paramsCollection;
    }

    /**
     * @param array $args
     * @return ParamsCollection
     * @throws Exception
     */
    public function build(array $args): ParamsCollection
    {
        /** @var Option $previousOption */
        $previousOption = null;
        foreach ($args as $arg) {
            if (preg_match('/^[a-zA-Z]+/', $arg)) {
                $this->paramsCollection->addArgument(new Argument($arg));
            }

            if (preg_match('/^{.*}$/', $arg)) {
                $arg = str_replace('{', '', $arg);
                $arg = str_replace('}', '', $arg);
                $data = explode(',', $arg);
                foreach ($data as $item) {
                    $this->paramsCollection->addArgument(new Argument($item));
                }
            }

            if (preg_match('/^\[.*]$/', $arg)) {
                $arg = str_replace('[', '', $arg);
                $arg = str_replace(']', '', $arg);
                $data = explode('=', $arg);

                if (count($data) !== 2) {
                    throw new Exception("Option $arg has invalid format");
                }

                if ($previousOption !== null && $previousOption->getName() === $data[0]) {
                    $previousOption->addArgument(new Argument($data[1]));
                } else {
                    $previousOption = new Option($arg);
                    $this->paramsCollection->addOption($previousOption);
                }
            }
        }

        return $this->paramsCollection;
    }
}
